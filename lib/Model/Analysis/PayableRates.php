<?php

/**
 * Created by PhpStorm.
 * @author domenico domenico@translated.net / ostico@gmail.com
 * Date: 12/05/15
 * Time: 15.04
 *
 */
class Analysis_PayableRates {

    public static $DEFAULT_PAYABLE_RATES = [
        'NO_MATCH'    => 100,
        '50%-74%'     => 100,
        //            '75%-99%'     => 60,
        '75%-84%'     => 60,
        '85%-94%'     => 60,
        '95%-99%'     => 60,
        '100%'        => 30,
        '100%_PUBLIC' => 30,
        'REPETITIONS' => 30,
        'INTERNAL'    => 60,
        'MT'          => 72
    ];

    protected static $langPair2MTpayableRates = [
        "de" => [
            'tr' => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ]
        ],
        "tr" => [
            'de' => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ]
        ],
        "en" => [
            "it" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 67
            ],
            'tr' => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "fr" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 67
            ],
            "pt" => [
                'NO_MATCH' => 100,
                '50%-74%'  => 100,
                //'75%-99%'     => 60,
                '75%-84%'  => 60,
                '85%-94%'  => 60,
                '95%-99%'  => 60,
                '100%'     => 30,

                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 67
            ],
            "es" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 67
            ],
            "nl" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 67
            ],
            "pl" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "uk" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "hi" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "fi" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "ru" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 82
            ],
            "zh" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 82
            ],
            "zh-HK" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 90
            ],
            "ar" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "ko" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 82
            ],
            "lt" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "ja" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "he" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "sr" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "ga" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "km" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "tl" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "xh" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "th" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
            "cs" => [
                'NO_MATCH'    => 100,
                '50%-74%'     => 100,
                //'75%-99%'     => 60,
                '75%-84%'     => 60,
                '85%-94%'     => 60,
                '95%-99%'     => 60,
                '100%'        => 30,
                '100%_PUBLIC' => 30,
                'REPETITIONS' => 30,
                'INTERNAL'    => 60,
                'MT'          => 77
            ],
        ]
    ];

    /**
     * Get the payable rate for a given langpair.
     * NB: the map is supposed to be symmetric. If there is the need to make it asymmetric, please change this method
     * and the corresponding map.
     *
     * @param $source        string The first two chars of the source language name in RFC3066<br/>
     *                       Example: <i>en-US</i> --> <b>en</b>
     * @param $target        string The first two chars of the target language name in RFC3066<br/>
     *                       Example: <i>en-US</i> --> <b>en</b>
     *
     * @return array
     */
    public static function getPayableRates( $source, $target ) {

        $resolveBreakdowns = self::resolveBreakdowns(static::$langPair2MTpayableRates, $source, $target);

        return (!empty($resolveBreakdowns)) ? $resolveBreakdowns : static::$DEFAULT_PAYABLE_RATES;
    }

    /**
     * @param $breakdowns
     * @param $source
     * @param $target
     * @return array|mixed
     */
    public static function resolveBreakdowns($breakdowns, $source, $target)
    {
        $isoSource = Utils::convertLanguageToIsoCode($source);
        $isoTarget = Utils::convertLanguageToIsoCode($target);

        if ( isset( $breakdowns[ $source ] ) ) {
            if ( isset( $breakdowns[ $source ][ $target ] ) ) {
                return $breakdowns[ $source ][ $target ];
            }

            if ( isset( $breakdowns[ $source ][ $isoTarget ] ) ) {
                return $breakdowns[ $source ][ $isoTarget ];
            }
        }

        if ( isset( $breakdowns[ $isoSource ] ) ) {
            if ( isset( $breakdowns[ $isoSource ][ $target ] ) ) {
                return $breakdowns[ $isoSource ][ $target ];
            }

            if ( isset( $breakdowns[ $isoSource ][ $isoTarget ] ) ) {
                return $breakdowns[ $isoSource ][ $isoTarget ];
            }
        }

        if ( isset( $breakdowns[ $target ] ) ) {
            if ( isset( $breakdowns[ $target ][ $source ] ) ) {
                return $breakdowns[ $target ][ $source ];
            }

            if ( isset( $breakdowns[ $target ][ $isoSource ] ) ) {
                return $breakdowns[ $target ][ $isoSource ];
            }
        }

        if ( isset( $breakdowns[ $isoTarget ] ) ) {
            if ( isset( $breakdowns[ $isoTarget ][ $source ] ) ) {
                return $breakdowns[ $isoTarget ][ $source ];
            }

            if ( isset( $breakdowns[ $isoTarget ][ $isoSource ] ) ) {
                return $breakdowns[ $isoTarget ][ $isoSource ];
            }
        }

        return [];
    }

    /**
     * This function returns the dynamic payable rate given a post-editing effort
     *
     * @param $pee float
     *
     * @return float
     */
    public static function pee2payable( $pee ) {
        $pee = floatval( $pee );

        // payable = ( aX^2 + bX + c ) * 100
        return round( ( -0.00032 * ( pow( $pee, 2 ) ) + 0.034 * $pee + 0.1 ) * 100, 1 );
    }

    public static function proposalPee( $payable ) {
        return min( 95, max( 75, $payable ) );
    }

    public static function wordsSavingDiff( $actual_payable, $proposal_payable, $word_count ) {
        return round( ( $actual_payable - $proposal_payable ) * $word_count );
    }

    private static function roundUpToAny( $n, $x = 5 ) {
        return ( round( $n ) % $x === 0 ) ? round( $n ) : round( ( $n + $x / 2 ) / $x ) * $x;
    }

}