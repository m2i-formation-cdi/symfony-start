<?php

namespace App\Controller;

use App\Service\GreetingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BraveKangarooController extends AbstractController
{
    /**
     * @var GreetingService
     */
    private $greeting;

    /**
     * BraveKangarooController constructor.
     * @param GreetingService $greeting
     */
    public function __construct(GreetingService $greeting)
    {
        $this->greeting = $greeting;
    }


    /**
     * @Route("/brave/kangaroo", name="brave_kangaroo")
     */
    public function index()
    {
        return $this->render('brave_kangaroo/index.html.twig', [
            'controller_name' => 'BraveKangarooController',
            'message' => $this->greeting->greet("Sam")
        ]);
    }
}
