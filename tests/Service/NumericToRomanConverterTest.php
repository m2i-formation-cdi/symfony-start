<?php
declare(strict_types=1);

namespace App\Tests;


use App\Service\NumericToRomanConverter;
use PHPUnit\Framework\TestCase;

class NumericToRomanConverterTest extends TestCase
{
    /**
     * @var NumericToRomanConverter
     */
    private $converter;

    protected function setUp()
    {
        $this->converter = new NumericToRomanConverter();
        parent::setUp();
    }


    public function optimisticProvider(){
        yield ["I", 1];
        yield ["III", 3];
        yield ["IV", 4];
        yield ["XLII", 42];
        yield ["MMXIX", 2019];
        yield ["MCMXCIX", 1999];

    }

    public function pessimisticProvider(){
        yield [0];
        yield [-15];
        yield [3001];
        yield [null];
    }



    /**
     * @param $expectedValue
     * @param $inputValue
     * @dataProvider optimisticProvider
     */
    public function testConvert($expectedValue, $inputValue){
        $this->assertEquals(
            $expectedValue,
            $this->converter->convert($inputValue)
        );
    }

    /**
     * @param $input
     * @expectedException \InvalidArgumentException
     * @dataProvider pessimisticProvider
     */
    public function testConvertThrowsInvalidArgumentException($input){
        $this->converter->convert($input);
    }

    /**
     * @param $input
     * @expectedException \TypeError
     */
    public function testConvertThrowsTypeErrorException(){
        $this->converter->convert(3.14159);
        $this->converter->convert("alea jacta est");
    }

}