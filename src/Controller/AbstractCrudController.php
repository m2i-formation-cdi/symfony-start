<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AbstractCrudController extends AbstractController
{

    protected $name = "";

    /**
     * @Route("/list")
     */
    public function indexAction(){
        return new Response("hello ". $this->name);
    }

}