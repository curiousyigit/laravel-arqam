<?php

return [
    /*
    |--------------------------------------------------------------------------
    | default_currency
    |--------------------------------------------------------------------------
    |
    | This is the default currency to be used
    |
    */
    'default_currency' => 'SAR',

    /*
    |--------------------------------------------------------------------------
    | round_exceeding_fractions
    |--------------------------------------------------------------------------
    |
    | This is a boolean that determines whether to round exceeding fractions
    | or not. The rounding index is determine by the currencies decimals
    | Example:
    |   When round_exceeding_fractions is set to true, and currency decimal is 2
    |       1.25 => 1.25
    |       1.250 => 1.25
    |       1.253 => 1.25
    |       1.255 => 1.30
    |       1.259 => 1.30
    |   When round_exceeding_fractions is set to false, and currency decimal is 2
    |       1.25 => 1.25
    |       1.250 => 1.25
    |       1.253 => 1.25
    |       1.255 => 1.25
    |       1.259 => 1.25
    |       
    |
    */
    'round_exceeding_fractions' => true,

    /*
    |--------------------------------------------------------------------------
    | prefix
    |--------------------------------------------------------------------------
    |
    | This is a string that will be added to beginning of the returned result
    | Example: 'فقط مائة ريال سعودي'
    |
    */
    'prefix' => 'فقط',

    /*
    |--------------------------------------------------------------------------
    | suffix
    |--------------------------------------------------------------------------
    |
    | This is a string that will be added to beginning of the returned result
    | Example: 'مائة ريال سعودي لا غير'
    |
    */
    'suffix' => 'لا غير',

    /*
    |--------------------------------------------------------------------------
    | currencies
    |--------------------------------------------------------------------------
    |
    | This is an array of currencies that the package uses
    |
    */
    'currencies' => [
        'SAR' => [
            'name' => 'الريال السعودي',
            'integer' => 'ريال سعودي',
            'fraction' => 'هللة',
            'decimals' => 2,
            'precision' => 4,
        ],
        'QAR' => [
            'name' => 'الريال القطري',
            'integer' => 'ريال قطري',
            'fraction' => 'درهم',
            'decimals' => 2,
            'precision' => 4,
        ],
        'AED' => [
            'name' => 'الدرهم الإماراتي',
            'integer' => 'درهم إماراتي',
            'fraction' => 'فلس',
            'decimals' => 2,
            'precision' => 4,
        ],
        'USD' => [
            'name' => 'الدولار الأمريكي',
            'integer' => 'دولار أمريكي',
            'fraction' => 'سنت',
            'decimals' => 2,
            'precision' => 4,
        ],
        'EUR' => [
            'name' => 'اليورو',
            'integer' => 'يورو',
            'fraction' => 'سنت',
            'decimals' => 2,
            'precision' => 4,
        ],
        'TRY' => [
            'name' => 'الليرا التركية',
            'integer' => 'ليرا تركية',
            'fraction' => 'قروش',
            'decimals' => 2,
            'precision' => 4,
        ],
        'BHD' => [
            'name' => 'الدينار البحريني',
            'integer' => 'دينار بحريني',
            'fraction' => 'فلس',
            'decimals' => 3,
            'precision' => 5,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | denominations
    |--------------------------------------------------------------------------
    |
    | This is an array of denominations
    |
    */
    'denominations' => [
        'ones' => [
            '0' => 'صفر',
            '1' => 'واحد',
            '2' => 'اثنان',
            '3' => 'ثلاثة',
            '4' => 'اربعة',
            '5' => 'خمسة',
            '6' => 'ستة',
            '7' => 'سبعة',
            '8' => 'ثمانية',
            '9' => 'تسعة',
        ],
        'teens' => [
            '11' => 'احد عشر',
            '12' => 'اثنا عشر',
            '13' => 'ثلاثة عشر',
            '14' => 'اربعة عشر',
            '15' => 'خمسة عشر',
            '16' => 'ستة عشر',
            '17' => 'سبعة عشر',
            '18' => 'ثمانية عشر',
            '19' => 'تسعة عشر',
        ],
        'tens' => [
            '10' => 'عشرة',
            '20' => 'عشرون',
            '30' => 'ثلاثون',
            '40' => 'أربعون',
            '50' => 'خمسون',
            '60' => 'ستون',
            '70' => 'سبعون',
            '80' => 'ثمانون',
            '90' => 'تسعون',
        ],
        'hundreds' => [
            '100' => 'مئة',
            '200' => 'مئتين',
            '300' => 'ثلاثمئة',
            '400' => 'اربعمئة',
            '500' => 'خمسمئة',
            '600' => 'ستمئة',
            '700' => 'سبعمئة',
            '800' => 'ثمانمئة',
            '900' => 'تسعمئة',
        ],
        'thousands' => [
            'singular' => 'الف',
            'binary' => 'الفين',
            'plural' => 'اﻵف',
        ],
        'millions' => [
            'singular' => 'مليون',
            'binary' => 'مليونين',
            'plural' => 'ملايين',
        ],
        'billions' => [
            'singular' => 'مليار',
            'binary' => 'مليارين',
            'plural' => 'مليارات',
        ],
        'trillions' => [
            'singular' => 'ترليون',
            'binary' => 'ترليونين',
            'plural' => 'ترليونات',
        ],
    ],
];