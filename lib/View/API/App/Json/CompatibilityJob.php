<?php
/**
 * Created by PhpStorm.
 * @author domenico domenico@translated.net / ostico@gmail.com
 * Date: 14/04/17
 * Time: 21.42
 *
 */

namespace API\App\Json;


use API\V2\Json\Job;
use API\V2\Json\JobTranslator;
use API\V2\Json\ProjectUrls;
use CatUtils;
use Chunks_ChunkStruct;
use DataAccess\ShapelessConcreteStruct;
use Features\ReviewExtended\ReviewUtils as ReviewUtils;
use FeatureSet;
use Langs_LanguageDomains;
use Langs_Languages;
use LQA\ChunkReviewDao;
use ManageUtils;
use OutsourceTo_OutsourceAvailable;
use Projects_MetadataDao;
use Projects_ProjectDao;
use Projects_ProjectStruct;
use Utils;
use WordCount\WordCountStruct;

/**
 * ( 2023/11/06 )
 *
 * This class is meant to allow back compatibility with running projects
 * after the advancement word-count switch from weighted to raw
 *
 * YYY [Remove] backward compatibility for current projects
 * YYY Remove after a reasonable amount of time
 */
class CompatibilityJob extends Job {

    /**
     * @param                         $chunk Chunks_ChunkStruct
     *
     * @param \Projects_ProjectStruct $project
     * @param FeatureSet              $featureSet
     *
     * @return array
     * @throws \Exception
     */
    public function renderItem( Chunks_ChunkStruct $chunk, Projects_ProjectStruct $project, FeatureSet $featureSet ) {

        $outsourceInfo = $chunk->getOutsource();
        $tStruct       = $chunk->getTranslator();
        $outsource     = null;
        $translator    = null;
        if ( !empty( $outsourceInfo ) ) {
            $outsource = ( new OutsourceConfirmation( $outsourceInfo ) )->render();
        } else {
            $translator = ( !empty( $tStruct ) ? ( new JobTranslator() )->renderItem( $tStruct ) : null );
        }

        $jobStats = WordCountStruct::loadFromJob( $chunk );

        $lang_handler = Langs_Languages::getInstance();

        $subject_handler = Langs_LanguageDomains::getInstance();
        $subjects        = $subject_handler->getEnabledDomains();

        $subjects_keys = Utils::array_column( $subjects, "key" );
        $subject_key   = array_search( $chunk->subject, $subjects_keys );

        $warningsCount = $chunk->getWarningsCount();

        // Added 5 minutes cache here
        $chunkReviews = ( new ChunkReviewDao() )->findChunkReviews( $chunk, 60 * 5 );

        // is outsource available?
        $outsourceAvailableInfo = $featureSet->filter( 'outsourceAvailableInfo', $chunk->target, $chunk->getProject()->id_customer, $chunk->id );

        // if the hook is not triggered by any plugin
        if ( !is_array( $outsourceAvailableInfo ) or empty( $outsourceAvailableInfo ) ) {
            $outsourceAvailableInfo = [
                    'disabled_email'         => false,
                    'custom_payable_rate'    => false,
                    'language_not_supported' => false,
            ];
        }

        $outsourceAvailable = OutsourceTo_OutsourceAvailable::isOutsourceAvailable( $outsourceAvailableInfo );

        $result = [
                'id'                    => (int)$chunk->id,
                'password'              => $chunk->password,
                'source'                => $chunk->source,
                'target'                => $chunk->target,
                'sourceTxt'             => $lang_handler->getLocalizedName( $chunk->source ),
                'targetTxt'             => $lang_handler->getLocalizedName( $chunk->target ),
                'job_first_segment'     => $chunk->job_first_segment,
                'status'                => $chunk->status_owner,
                'subject'               => $chunk->subject,
                'subject_printable'     => $subjects[ $subject_key ][ 'display' ],
                'owner'                 => $chunk->owner,
                'open_threads_count'    => (int)$chunk->getOpenThreadsCount(),
                'create_timestamp'      => strtotime( $chunk->create_date ),
                'created_at'            => Utils::api_timestamp( $chunk->create_date ),
                'create_date'           => $chunk->create_date,
                'formatted_create_date' => ManageUtils::formatJobDate( $chunk->create_date ),
                'quality_overall'       => CatUtils::getQualityOverallFromJobStruct( $chunk, $chunkReviews ),
                'pee'                   => $chunk->getPeeForTranslatedSegments(),
                'tte'                   => (int)( (int)$chunk->total_time_to_edit / 1000 ),
                'private_tm_key'        => $this->getKeyList( $chunk ),
                'warnings_count'        => $warningsCount->warnings_count,
                'warning_segments'      => ( isset( $warningsCount->warning_segments ) ? $warningsCount->warning_segments : [] ),
                'word_count_type'       => $chunk->getProject()->getWordCountType(),
                'stats'                 => ( $chunk->getProject()->getWordCountType() == Projects_MetadataDao::WORD_COUNT_RAW ?
                        $jobStats :
                        ReviewUtils::formatStats( CatUtils::getFastStatsForJob( $jobStats, false, $chunk->getProject()->getWordCountType() ), $chunkReviews )
                ),
                'outsource'             => $outsource,
                'outsource_available'   => $outsourceAvailable,
                'outsource_info'        => $outsourceAvailableInfo,
                'translator'            => $translator,
                'total_raw_wc'          => (int)$chunk->total_raw_wc,
                'standard_wc'           => (float)$chunk->standard_analysis_wc,
                'quality_summary'       => [
                        'quality_overall' => $chunk->getQualityOverall( $chunkReviews ),
                        'errors_count'    => (int)$chunk->getErrorsCount()
                ],

        ];

        // add revise_passwords to stats
        foreach ( $chunkReviews as $chunk_review ) {

            if ( $chunk_review->source_page <= \Constants::SOURCE_PAGE_REVISION ) {
                $result[ 'revise_passwords' ][] = [
                        'revision_number' => 1,
                        'password'        => $chunk_review->review_password
                ];
            } else {
                $result[ 'revise_passwords' ][] = [
                        'revision_number' => ReviewUtils::sourcePageToRevisionNumber( $chunk_review->source_page ),
                        'password'        => $chunk_review->review_password
                ];
            }

        }

        $project = $chunk->getProject();

        /**
         * @var $projectData ShapelessConcreteStruct[]
         */
        $projectData = ( new Projects_ProjectDao() )->setCacheTTL( 60 * 60 * 24 )->getProjectData( $project->id, $project->password );

        $formatted = new ProjectUrls( $projectData );

        /** @var $formatted ProjectUrls */
        $formatted = $featureSet->filter( 'projectUrls', $formatted );

        $urlsObject       = $formatted->render( true );
        $result[ 'urls' ] = $urlsObject[ 'jobs' ][ $chunk->id ][ 'chunks' ][ $chunk->password ];

        $result[ 'urls' ][ 'original_download_url' ]    = $urlsObject[ 'jobs' ][ $chunk->id ][ 'original_download_url' ];
        $result[ 'urls' ][ 'translation_download_url' ] = $urlsObject[ 'jobs' ][ $chunk->id ][ 'translation_download_url' ];
        $result[ 'urls' ][ 'xliff_download_url' ]       = $urlsObject[ 'jobs' ][ $chunk->id ][ 'xliff_download_url' ];

        return $result;

    }

}