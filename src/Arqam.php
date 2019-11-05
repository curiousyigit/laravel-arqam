<?php

namespace hopefeda\LaravelArqam;

class Arqam
{
    protected $currency;
    protected $denominations;

    public function __construct($currency = null)
    {
        $currencies = config('arqam.currencies');
        if($currency)
            $this->currency = $currencies[$currency];
        else
            $this->currency = $currencies[config('arqam.default_currency')];

        $this->denominations = config('arqam.denominations');
    }

    public function hello()
    {
        return 'Hello, it\'s laravel-arqam!';
    }

    public function currency()
    {
        return $this->currency;
    }

    public function currencyName()
    {
        return $this->currency['name'];
    }

    public function wordsNoCurrency(String $number, $decimals = 2, $precision = 3, $roundExceeding = null, $numbersOnlySeparator = 'فاصلة', $outOfRangeMessage = null)
    {
        return $this->words($number, null, $decimals, $precision, $roundExceeding, $outOfRangeMessage, true, $numbersOnlySeparator);
    }

    public function words(String $number, $currency = null, $decimals = null, $precision = null, $roundExceeding = null, $outOfRangeMessage = null, $numbersOnly = false, $numbersOnlySeparator = null)
    {
        $currency = ($currency ? config('arqam.currencies')[$currency]:$this->currency);
        $denominations = $this->denominations;
        if(!$decimals) $decimals = $currency['decimals'];
        if(!$precision) $precision = $currency['precision'];

        $result = '';

        //Check if contains fractions
        $exploded = explode(".", $number);

        //Get length of digits
        $len = strlen($exploded[0]);

        //If more than trillions, return not in range message
        if($len > 15) return ($outOfRangeMessage == null ? config('arqam.out_of_range_message'):$outOfRangeMessage);
        
        // -- Deal with integer part
        $integer = $exploded[0];
        $result .= $this->read($integer);

        //Add currency name
        if(!$numbersOnly)
            $result .= ' '.$currency['integer'];

        // --- Deal with fraction part
        if(count($exploded) == 2 && $decimals)
        {
            $curResult = '';
            $integers = $this->adjustForPrecision($exploded[1], $precision);

            if(substr($integers, 0, $precision) != 0)
            {
                $required = '0.'.substr($integers, 0, $precision);
                $rounded = round((float)($required), $decimals);
                $rounded = $this->adjustForPrecision(substr($rounded, 2), $precision);
                $readable = substr($rounded, 0, $decimals);
                $curResult .= $this->read($readable, $outOfRangeMessage, false);
                
                if($readable != 0)
                {
                    //Add currency fractions name
                    if(!$numbersOnly)
                        $curResult = ' و'.$curResult.' '.$currency['fraction'];
                    else
                    {
                        //Add fraction name
                        $curResult = ' '.$numbersOnlySeparator.' '.$curResult;
                    }

                    $result .= $curResult;
                }
            }
        }

        //Add prefix
        $result = config('arqam.prefix').' '.$result;

        //Add suffix
        $result .= ' '.config('arqam.suffix');

        return $result;
    }

    private function read($integer, $readZero = true)
    {
        $result = '';

        //Get length of digits
        $len = strlen($integer);

        //fill with blank zeros in the beginning if length is not exactly 15
        if($len != 15)
        {
            for($i = 0; $i < 15 - $len; $i++)
            {
                $integer = '0'.$integer;
            }
            $len = 15;
        }

        if($integer == 0)
        {
            if($readZero)
                $result .= $this->denominations['ones'][0];
        }
        else
        {
            $andRequired = false;
            for($i = 0; $i < $len; $i = $i + 3)
            {
                //Get group in hudreds
                $g = $integer[$i].$integer[$i + 1].$integer[$i + 2];

                $range = '';
                if($i <= 2)
                {
                    //group is trillions
                    $range = 'trillions';
                }
                elseif($i >= 3 && $i <= 5)
                {
                    //group is billions
                    $range = 'billions';
                }
                elseif($i >= 6 && $i <= 8)
                {
                    //group is millions
                    $range = 'millions';
                }
                elseif($i >= 9 && $i <= 11)
                {
                    //group is thousands
                    $range = 'thousands';
                }
                else
                {
                    //group is hundreds
                    $range = 'hundreds';
                }

                $groupResult = $this->readGroup($g, $range);

                if($groupResult != '')
                {
                    if($andRequired)
                    {
                        $result .= ' و';
                        $andRequired = false;
                    }

                    $andRequired = true;
                }

                $result .= $groupResult;
            }
        }

        return $result;
    }

    private function readGroup($val, $range)
    {
        $denominations = $this->denominations;

        $result = '';

        $h = $val[0];
        $t = $val[1];
        $o = $val[2];
        $p = '';
        $removeWord = false;

        if($h >= 1)
        {
            //hundreds
            $result .= $denominations['hundreds'][$h.'00'];

            if($t >= 1)
            {
                if($t.$o >= 11 && $t.$o <= 19)
                    $result .= ' و'.$denominations['teens'][$t.$o];
                elseif($o == 0)
                    $result .= ' و'.$denominations['tens'][$t.$o];
                else
                    $result .= ' و'.$denominations['ones'][$o].' و'.$denominations['tens'][$t.'0'];
            }
            elseif($t == 0 && $o >= 1)
                $result .= ' و'.$denominations['ones'][$o];

            if($t.$o <= 2 || $t.$o >= 11)
                $p = 'singular';
            else
                $p = 'plural';
            
        }
        elseif($t >= 1)
        {
            //tens or teens
            if($t == 1 && $o >= 1)
                $result .= $denominations['teens'][$t.$o];
            elseif($t >= 1 && $o == 0)
                $result .= $denominations['tens'][$t.$o];
            else
                $result .= $denominations['ones'][$o].' و'.$denominations['tens'][$t.'0'];

            if($t.$o >= 11)
                $p = 'singular';
            else
                $p = 'plural';
        }
        elseif($o >= 1)
        {
            //ones
            $result .= $denominations['ones'][$o];

            if($o == 1)
            {
                $p = 'singular';
                $removeWord = true;
            }
            elseif($o == 2)
            {
                $p = 'binary';
                $removeWord = true;
            }
            else
                $p = 'plural';

        }
        else
        {
            //group is zero
            return '';
        }

        if(in_array($range, ['trillions', 'billions', 'millions', 'thousands']))
        {
            if($removeWord)
                $result = '';
            $result .= ' '.$denominations[$range][$p];
        }

        return $result;
    }

    private function adjustForPrecision($integers, $precision)
    {
        $result = $integers;
        $len = strlen($result);

        if($len < $precision)
        {
            for($i = 0; $i < $precision - $len; $i++)
            {
                $result .= '0';
            }
        }

        return $result;
    }
}