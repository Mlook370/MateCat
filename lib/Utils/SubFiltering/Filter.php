<?php
/**
 * Created by PhpStorm.
 * @author domenico domenico@translated.net / ostico@gmail.com
 * Date: 12/11/18
 * Time: 11.09
 *
 */

namespace SubFiltering;

use FeatureSet;
use SubFiltering\Commons\Pipeline;
use SubFiltering\Filters\CtrlCharsPlaceHoldToAscii;
use SubFiltering\Filters\EncodeToRawXML;
use SubFiltering\Filters\EntitiesDecode;
use SubFiltering\Filters\HtmlToEntities;
use SubFiltering\Filters\HtmlToPh;
use SubFiltering\Filters\LtGtDoubleEncode;
use SubFiltering\Filters\LtGtEncode;
use SubFiltering\Filters\PlaceHoldCtrlCharsForView;
use SubFiltering\Filters\PlaceHoldXliffTags;
use SubFiltering\Filters\RestoreEquivTextPhToXliffOriginal;
use SubFiltering\Filters\RestorePlaceHoldersToXLIFFLtGt;
use SubFiltering\Filters\RestoreXliffTagsContent;
use SubFiltering\Filters\RestoreXliffTagsForView;
use SubFiltering\Filters\SprintfToPH;
use SubFiltering\Filters\SubFilteredPhToHtml;
use SubFiltering\Filters\TwigToPh;

/**
 * Class Filter
 *
 * This class is meant to create subfiltering layers to allow data to be safely sent and received from 2 different Layers and real file
 *
 * # Definitions
 *
 * - Raw file, the real xml file in input, with data in XML
 * - Layer 0 is defined to be the Database. The data stored in the database should be in the same form ( sanitized if needed ) they comes from Xliff file
 * - Layer 1 is defined to be external services and resources, for example MT/TM server. This layer is different from layer 0, HTML subfiltering is applied here
 * - Layer 2 is defined to be the MayeCat UI.
 *
 * # Constraints
 * - We have to maintain the compatibility with PH tags placed inside the XLIff in the form <ph id="[0-9+]" equiv-text="&lt;br/&gt;"/>, those tags are placed into the database as XML
 * - HTML and other variables like android tags and custom features are placed into the database as encoded HTML &lt;br/&gt;
 *
 * - Data sent to the external services like MT/TM are sub-filtered:
 * -- &lt;br/&gt; become <ph id="mtc_[0-9]+" equiv-text="base64:Jmx0O2JyLyZndDs="/>
 * -- Existent tags in the XLIFF like <ph id="[0-9+]" equiv-text="&lt;br/&gt;"/> will leaved as is
 *
 *
 * @package SubFiltering
 */
class Filter {

    /**
     * @var Filter
     */
    protected static $_INSTANCE;

    /**
     * @var FeatureSet
     */
    protected $_featureSet;

    protected function __construct() {}

    /**
     * Update/Add featureSet
     *
     * @param FeatureSet|null $featureSet
     */
    protected function _featureSet( FeatureSet $featureSet = null ){
        $this->_featureSet = $featureSet;
    }

    /**
     * @param FeatureSet $featureSet
     *
     * @return Filter
     * @throws \Exception
     */
    public static function getInstance( FeatureSet $featureSet = null ) {

        if( $featureSet === null ){
            $featureSet = new FeatureSet();
        }

        if( static::$_INSTANCE === null ){
            static::$_INSTANCE = new Filter();
        }

        static::$_INSTANCE->_featureSet( $featureSet );
        return static::$_INSTANCE;

    }

    /**
     * Used to transform database raw xml content ( Layer 0 ) to the UI structures ( Layer 2 )
     *
     * @param $segment
     *
     * @return mixed
     * @throws \API\V2\Exceptions\AuthenticationError
     * @throws \Exceptions\ValidationError
     * @throws \Exceptions_RecordNotFound
     * @throws \TaskRunner\Exceptions\EndQueueException
     * @throws \TaskRunner\Exceptions\ReQueueException
     */
    public function fromLayer0ToLayer2( $segment ) {

        $channel = new Pipeline();
        $channel->addLast( new PlaceHoldXliffTags() );
        $channel->addLast( new EntitiesDecode() );
        $channel->addLast( new HtmlToPh() );
        $channel->addLast( new TwigToPh() );
        $channel->addLast( new SprintfToPH() );
        $channel->addLast( new LtGtDoubleEncode() );
        $channel->addLast( new RestoreXliffTagsForView() );
        $channel->addLast( new PlaceHoldCtrlCharsForView() );
        $channel->addLast( new LtGtEncode() );
        $channel = $this->_featureSet->filter( 'fromLayer0ToLayer2', $channel );
        return $channel->transform( $segment );

    }

    /**
     * Used to transform database raw xml content ( Layer 0 ) to the UI structures ( Layer 2 )
     *
     * @param $segment
     *
     * @return mixed
     * @throws \API\V2\Exceptions\AuthenticationError
     * @throws \Exceptions\ValidationError
     * @throws \Exceptions_RecordNotFound
     * @throws \TaskRunner\Exceptions\EndQueueException
     * @throws \TaskRunner\Exceptions\ReQueueException
     */
    public function fromLayer1ToLayer2( $segment ) {

        $channel = new Pipeline();
        $channel->addLast( new RestoreXliffTagsForView() );
        $channel->addLast( new LtGtDoubleEncode() );
        $channel->addLast( new LtGtEncode() );
        $channel = $this->_featureSet->filter( 'fromLayer1ToLayer2', $channel );
        return $channel->transform( $segment );

    }

    /**
     * Used to transform UI data ( Layer 2 ) to the XML structures ( Layer 1 )
     *
     * @param $segment
     *
     * @return mixed
     * @throws \API\V2\Exceptions\AuthenticationError
     * @throws \Exceptions\ValidationError
     * @throws \Exceptions_RecordNotFound
     * @throws \TaskRunner\Exceptions\EndQueueException
     * @throws \TaskRunner\Exceptions\ReQueueException
     */
    public function fromLayer2ToLayer1( $segment ) {
        $channel = new Pipeline();
        $channel->addLast( new PlaceHoldXliffTags() );
        $channel->addLast( new EncodeToRawXML() );
        $channel->addLast( new HtmlToEntities() );
        $channel->addLast( new RestoreXliffTagsContent() );
        $channel->addLast( new RestorePlaceHoldersToXLIFFLtGt() );
        $channel = $this->_featureSet->filter( 'fromLayer2ToLayer1', $channel );
        return $channel->transform( $segment );

    }

    /**
     *
     * Used to transform the UI structures ( Layer 2 ) to allow them to be stored in database ( Layer 0 )
     *
     * @param $segment
     *
     * @return mixed
     * @throws \API\V2\Exceptions\AuthenticationError
     * @throws \Exceptions\ValidationError
     * @throws \Exceptions_RecordNotFound
     * @throws \TaskRunner\Exceptions\EndQueueException
     * @throws \TaskRunner\Exceptions\ReQueueException
     */
    public function fromLayer2ToLayer0( $segment ) {

        $channel = new Pipeline();
        $channel->addLast( new CtrlCharsPlaceHoldToAscii() );
        $channel->addLast( new PlaceHoldXliffTags() );
        $channel->addLast( new EncodeToRawXML() );
        $channel->addLast( new HtmlToEntities() );
        $channel->addLast( new RestoreXliffTagsContent() );
        $channel->addLast( new RestoreEquivTextPhToXliffOriginal() );
        $channel->addLast( new RestorePlaceHoldersToXLIFFLtGt() );
        $channel->addLast( new SubFilteredPhToHtml() );
        $channel = $this->_featureSet->filter( 'fromLayer2ToLayer0', $channel );
        return $channel->transform( $segment );

    }


    /**
     * Used to transform database raw xml content ( Layer 0 ) to the sub filtered structures, used for server to server ( Ex: TM/MT ) communications ( Layer 1 )
     *
     * @param $segment
     *
     * @return mixed
     * @throws \API\V2\Exceptions\AuthenticationError
     * @throws \Exceptions\ValidationError
     * @throws \Exceptions_RecordNotFound
     * @throws \TaskRunner\Exceptions\EndQueueException
     * @throws \TaskRunner\Exceptions\ReQueueException
     */
    public function fromLayer0ToLayer1( $segment ) {

        $channel = new Pipeline();
        $channel->addLast( new PlaceHoldXliffTags() );
        $channel->addLast( new EncodeToRawXML() );
        $channel->addLast( new EntitiesDecode() );
        $channel->addLast( new HtmlToPh() );
        $channel->addLast( new TwigToPh() );
        $channel->addLast( new SprintfToPH() );
        $channel->addLast( new RestoreXliffTagsContent() );
        $channel->addLast( new RestorePlaceHoldersToXLIFFLtGt() );
        $channel = $this->_featureSet->filter( 'fromLayer0ToLayer1', $channel );
        return $channel->transform( $segment );

    }

    /**
     * Used to transform external server raw xml content ( Ex: TM/MT ) to allow them to be stored in database ( Layer 0 ), used for server to server communications ( Layer 1 )
     *
     * @param $segment
     *
     * @return mixed
     * @throws \API\V2\Exceptions\AuthenticationError
     * @throws \Exceptions\ValidationError
     * @throws \Exceptions_RecordNotFound
     * @throws \TaskRunner\Exceptions\EndQueueException
     * @throws \TaskRunner\Exceptions\ReQueueException
     */
    public function fromLayer1ToLayer0( $segment ) {

        $channel = new Pipeline();
        $channel->addLast( new LtGtDoubleEncode() );
        $channel->addLast( new SubFilteredPhToHtml() );
        $channel->addLast( new PlaceHoldXliffTags() );
        $channel->addLast( new EncodeToRawXML() );
        $channel->addLast( new RestoreXliffTagsContent() );
        $channel->addLast( new RestorePlaceHoldersToXLIFFLtGt() );
        $channel = $this->_featureSet->filter( 'fromLayer1ToLayer0', $channel );
        return $channel->transform( $segment );
    }

    /**
     * Used to convert the raw XLIFF content from file to an XML for the database ( Layer 0 )
     *
     * @param $segment
     *
     * @return mixed
     * @throws \API\V2\Exceptions\AuthenticationError
     * @throws \Exceptions\ValidationError
     * @throws \Exceptions_RecordNotFound
     * @throws \TaskRunner\Exceptions\EndQueueException
     * @throws \TaskRunner\Exceptions\ReQueueException
     */
    public function fromRawXliffToLayer0( $segment ) {

        $channel = new Pipeline();
        $channel->addLast( new PlaceHoldXliffTags() );
        $channel->addLast( new EncodeToRawXML() );
        $channel->addLast( new RestoreXliffTagsContent() );
        $channel->addLast( new RestorePlaceHoldersToXLIFFLtGt() );
        $channel = $this->_featureSet->filter( 'fromRawXliffToLayer0', $channel );
        return $channel->transform( $segment );

    }

    /**
     * Used to export Database XML string into TMX files as valid XML
     *
     * @param $segment
     *
     * @return mixed
     * @throws \API\V2\Exceptions\AuthenticationError
     * @throws \Exceptions\ValidationError
     * @throws \Exceptions_RecordNotFound
     * @throws \TaskRunner\Exceptions\EndQueueException
     * @throws \TaskRunner\Exceptions\ReQueueException
     */
    public function fromLayer0ToRawXliff( $segment ) {

        $channel = new Pipeline();
        $channel->addLast( new PlaceHoldXliffTags() );
        $channel->addLast( new HtmlToEntities() );
        $channel->addLast( new RestoreXliffTagsForView() );
        $channel = $this->_featureSet->filter( 'fromLayer0ToRawXliff', $channel );
        return $channel->transform( $segment );

    }

    /**
     * Used to align the tags when created from Layer 0 to Layer 1, when converting data from database there is possible that html placeholders are in different positions
     * and their id are ordered differently.
     *
     * The source own the reason, re-align target id by matching the base64 content.
     *
     * @param $source
     * @param $target
     *
     * @return string
     */
    public function realignIDInLayer1( $source, $target ){

        $pattern = '|<ph id ?= ?["\'](?:mtc_[0-9]+)["\'] ?(equiv-text=["\'].+?["\'] ?)/>|ui';
        preg_match_all( $pattern, $source, $src_tags, PREG_PATTERN_ORDER );
        preg_match_all( $pattern, $target, $trg_tags, PREG_PATTERN_ORDER );

        if( count( $src_tags[ 0 ] ) != count( $trg_tags[ 0 ] ) ){
            return $target; //WRONG NUMBER OF TAGS, in the translation there is a tag mismatch, let the user fix it
        }

        $start_offset = 0;
        foreach ( $trg_tags[ 1 ] as $trg_tag_position => $b64 ){

            $src_tag_position = array_search( $b64, $src_tags[ 1 ], true );
            unset( $src_tags[ 1 ][ $src_tag_position ] ); // remove the index to allow array_search to find the equal next one if it is present

            //replace ONLY ONE element AND the EXACT ONE
            $tag_position_in_string = strpos( $target, $trg_tags[ 0 ][ $trg_tag_position ], $start_offset );
            $target = substr_replace( $target, $src_tags[ 0 ][ $src_tag_position ], $tag_position_in_string, strlen( $trg_tags[ 0 ][ $trg_tag_position ] ) );
            $start_offset = $tag_position_in_string + strlen( $src_tags[ 0 ][ $src_tag_position ] ); // set the next starting point

        }

        return $target;

    }

}