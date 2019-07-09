<?php

namespace App\Controller;

use App\Service\GreetingService;
use App\Service\MessagerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BraveKangarooController extends AbstractController
{
    /**
     * @var GreetingService
     */
    private $greeting;
    /**
     * @var MessagerService
     */
    private $messagerService;

    /**
     * BraveKangarooController constructor.
     * @param GreetingService $greeting
     */
    public function __construct(GreetingService $greeting, MessagerService $messagerService)
    {
        $this->greeting = $greeting;
        $this->messagerService = $messagerService;
    }


    /**
     * @Route("/brave/kangaroo", name="brave_kangaroo")
     */
    public function index()
    {
        $this->messagerService->send();
        return $this->render('brave_kangaroo/index.html.twig', [
            'controller_name' => 'BraveKangarooController',
            'message' => $this->greeting->greet("Sam")
        ]);
    }
}
