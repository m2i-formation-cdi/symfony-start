<?php


namespace App\Service;


class NumericToRomanConverter
{

    private static $map = [
        1000  => "M",
        900   => "CM",
        500   => "D",
        400   => "CD",
        100   => "C",
        90    => "XC",
        50    => "L",
        40    => "XL",
        10    => "X",
        9     => "IX",
        5     => "V",
        4     => "IV",
        1     => "I"
    ];

    public function convert(? int $number)
    {

        if(! is_numeric($number) || $number > 3000 || $number<1 || is_null($number)){
            throw new \InvalidArgumentException();
        }

        $romanString = "";
        foreach (self::$map as $decimal=>$roman){
            $numberOfSigns = (int) ($number/$decimal);
            $romanString .= str_repeat($roman, $numberOfSigns);
            $number -= $decimal * $numberOfSigns;
        }

        return $romanString;
    }
}