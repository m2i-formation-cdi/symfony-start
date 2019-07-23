<?php


namespace App\Tests\Service;


use App\Service\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{

    public function AddProviderTest(){
        return [
            [[1,1], 2, "Un plus un ne font pas deux"],
            [[100,0], 100, "Zéro plus cent ne font pas cent"],
            [[null,5], null, "Null plus 5 ne font pas null"],
            [[-5, 5], 0, "moins cinq plus cinq ne font pas zéro"]
        ];
    }

    /**
     * @dataProvider AddProviderTest
     */
    public function testAdd($input, $output, $message){
        $calculator= new Calculator();

        $result = $calculator->add($input[0],$input[1]);

        var_dump($calculator->add(100,0));

        $this->assertEquals($output, $result, $message);
    }

}