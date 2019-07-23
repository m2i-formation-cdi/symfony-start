<?php


namespace App\Tests\Service;


use App\Service\GreetingService;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class GreetingServiceTest extends TestCase
{

    /**
     * @var Logger
     */
    private $logger;

    protected function setUp()
    {
        $this->logger = $this ->getMockBuilder(Logger::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->logger->method('info')->willReturn(true);
    }


    public function testGreeting(){
        $greetingService = new GreetingService($this->logger, "Test");

        $this->assertEquals(
            "Hello Sam from Test",
            $greetingService->greet("Sam")
        );
    }

    public function testGreetingWithoutFrom(){
        $greetingService = new GreetingService($this->logger, "");
        $this->assertEquals(
            "Hello Sam",
            $greetingService->greet("Sam")
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Le nom est obligatoire
     */
    public function testGreetingWithoutNameArgument(){
        $greetingService = new GreetingService($this->logger, "");
        $greetingService->greet(null);
    }

}