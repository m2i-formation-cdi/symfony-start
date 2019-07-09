<?php


namespace App\Service;


use Psr\Log\LoggerInterface;

class GreetingService
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * GreetingService constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    public function greet($name){
        $this->logger->info("$name greeted");
        return "Hello $name";
    }

}