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
     * @var string
     */
    private $from;

    /**
     * GreetingService constructor.
     * @param LoggerInterface $logger
     * @param string $from
     */
    public function __construct(LoggerInterface $logger, string $from)
    {
        $this->logger = $logger;
        $this->from = trim($from);
    }


    public function greet($name){
        $this->logger->info("$name greeted by {$this->from}");

        if(! empty($this->from)){
           $this->from = " from {$this->from}";
        }

        if(empty($name)){
            throw new \InvalidArgumentException("Le nom est obligatoire");
        }

        return "Hello $name{$this->from}";
    }

}