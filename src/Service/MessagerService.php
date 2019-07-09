<?php


namespace App\Service;


use Psr\Log\LoggerInterface;

class MessagerService
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
     * MessagerService constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger, string $from)
    {
        $this->logger = $logger;
        $this->from = $from;
    }

    public function send(){
        $this->logger->info("message send from {$this->from}");

    }


}