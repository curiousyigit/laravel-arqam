# laravel-arqam 
laravel-arqam helps you convert numbers to arabic words

## Installation
Installation is straightforward, setup is similar to every other Laravel Package.

**1. Install via composer**
```
composer require hopefeda/laravel-arqam
```

**2. Define the Service Provider and alias**  
**Note:** You can skip this step if you are using laravel 5.5 and above as this package supports "**auto-discovery**".  

If you are using Laravel 5.0 - 5.4 then you need to add a provider and alias. Inside of your `config/app.php` define a new service provider.
```
'providers' => [
	//  other providers

	hopefeda\LaravelArqam\ServiceProvider::class,
];
```

Then we want to define an alias in the same `config/app.php` file.
```
'aliases' => [
	// other aliases

	'laravel-arqam' => hopefeda\LaravelArqam\Facade::class,
];
```

**3. Publish Config File**  
The config file allows you to override default settings of this package to meet your specific needs. It also allows you to add your custom currencies.

To generate a config file type this command into your terminal:
```
php artisan vendor:publish  --provider=hopefeda\LaravelArqam\ServiceProvider
```
This generates a config file at config/arqam.php.

## Usage
This package is very easy to use. Once installed, you can start converting numbers to words in controllers, views, middlewares, models, etc.

**IMPORTANT**
The words function expects the number as a **string**. This is done because php has problems dealing with huge numbers. So convert your numbers to **non scientific notation** strings. Decimals are optional. **DO NOT** use numbers with thousand separators. The supported decimal separator is a dot ".". Not applying these precautions may cause unwanted functionality

## Limitation
Currently, the maximum supported number is (trillions) 999999999999999.999999999. At the time of coding I didn't really see a need in bigger number. I may change it in the future though

**A few examples:**  
```
Arqam::words(15500); //فقط الف وخمسمئة وخمسون ريال سعودي لا غير
Arqam::words(169855.2586); //فقط مئة وتسعة وستون الف وثمانمئة وخمسة وخمسون ريال سعودي وستة وعشرون هللة لا غير
Arqam::words(169855.2586, 'BHD', 3, 3); //فقط مئة وتسعة وستون الف وثمانمئة وخمسة وخمسون دينار بحريني ومئتين وثمانية وخمسون فلس لا غير
Arqam::wordsNoCurrency(7900); //فقط سبعة اﻵف وتسعمئة لا غير
Arqam::wordsNoCurrency('4544.446', 2, 2); //فقط اربعة اﻵف وخمسمئة واربعة وأربعون فاصلة اربعة وأربعون لا غير
Arqam::wordsNoCurrency('4544.446', 2, 3); //فقط اربعة اﻵف وخمسمئة واربعة وأربعون فاصلة خمسة وأربعون لا غير
Arqam::wordsNoCurrency('8500.789', 2, 3, null, 'ويتضمن كسور بمقدار'); //فقط ثمانية اﻵف وخمسمئة ويتضمن كسور بمقدار تسعة وسبعون لا غير
Arqam::words(15500); //suffix and prefix set to '' in settings, gives: الف وخمسمئة وخمسون ريال سعودي
```

## Functions
**1. words(string $number [, string $currency, int $decimals, int $precision, bool $roundExceeding, string $outOfRangeMessage, bool $numbersOnly, string $numbersOnlySeparator]) - Returns a string representing the literal words of the number given as a currency notation**  
This function is used to convert a number string to arabic words as a currency notation.

**2. wordsNoCurrency(string $number [, int $decimals, int $precision, bool $roundExceeding, string $numbersOnlySeparator, string $outOfRangeException]) - Returns a string representing the literal words of the number without currency notation**  
This function is used to convert a number string to arabic words without currency notation.

**3. currency() - Gets the currently set currency** 

**4. currencyName() - Gets the currently set currencies name** 

**Note:** If you want to use the laravel-arqam functions within your controllers, don't forget to add `use Arqam;` at the beginning of your controller.
```
// Example
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Arqam;

class TestController extends Controller
{
    public function something()
    {
        return Arqam::words('486532');
    }
}

```  

## Configurables
You can configure various properties from the `config/laravel-arqam.php` file.
```
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
```
## Contribute  
I encourage you to contribute to this package to improve it and make it better. Even if you don't feel comfortable with coding or submitting a pull-request (PR), you can still support it by submitting issues with bugs or requesting new features, or simply helping discuss existing issues to give us your opinion and shape the progress of this package. Best regards!

## Planned (Help if you can!)
- Add thousands separator support
- Add different decimal separator support