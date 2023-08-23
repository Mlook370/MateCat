<?php

use PayableRates\CustomPayableRateStruct;

/**
 * Created by PhpStorm.
 * User: fregini
 * Date: 09/06/2017
 * Time: 16:51
 */
class CustomPayableRateStructTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function getPayableRates()
    {
        $model = new CustomPayableRateStruct();
        $model->id = 12;
        $model->name = 'test';
        $model->version = 2;
        $model->breakdowns = '
            {
                "default": {
                    "NO_MATCH": 80,
                    "50%-74%": 80,
                    "75%-84%": 80,
                    "85%-94%": 80,
                    "95%-99%": 80,
                    "100%": 80,
                    "100%_PUBLIC": 80,
                    "REPETITIONS": 80,
                    "INTERNAL": 80,
                    "ICE": 80,
                    "ICE_MT": 80,
                    "MT": 80
                },
                "en": {
                    "fr": {
                        "NO_MATCH": 70,
                        "50%-74%": 70,
                        "75%-84%": 70,
                        "85%-94%": 70,
                        "95%-99%": 70,
                        "100%": 70,
                        "100%_PUBLIC": 70,
                        "REPETITIONS": 70,
                        "INTERNAL": 70,
                        "MT": 70,
                        "ICE": 70,
                        "ICE_MT": 70
                    }
                },
                "en-US": {
                    "fr-CA": {
                        "NO_MATCH": 75,
                        "50%-74%": 75,
                        "75%-84%": 75,
                        "85%-94%": 75,
                        "95%-99%": 75,
                        "100%": 75,
                        "100%_PUBLIC": 75,
                        "REPETITIONS": 75,
                        "INTERNAL": 75,
                        "MT": 75,
                        "ICE": 75,
                        "ICE_MT": 75
                    }
                }
            }
        ';

        $languageCombos = [
            ['en', 'fr', 70],
            ['en-GB', 'fr', 70],
            ['en-GB', 'fr-FR', 70],
            ['en-US', 'fr-CA', 75],
            ['en-US', 'fr', 70],
            ['it', 'fr', 80],
        ];

        foreach ($languageCombos as $languageCombo){
            $payableRate = $model->getPayableRates($languageCombo[0], $languageCombo[1]);
            $errorMessage = 'Error for language combination '.$languageCombo[0].'<->'.$languageCombo[1].'. Exp. '.$languageCombo[2].', got ' . $payableRate['MT'];

            $this->assertEquals($languageCombo[2], $payableRate['MT'], $errorMessage);
        }
    }
}