<?php


namespace App\Service;


class Calculator
{

    public function add($n1, $n2){

        if($n1 === null || $n2 === null){
            return null;
        }

        return $n1 + $n2;
    }

}