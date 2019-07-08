<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test")
 * Class HomeController
 * @package App\Controller
 */
class HomeController
{

    /**
     * @Route(  "/home/{nameOfPerson}",
     *          name="home_index",
     *          defaults={"nameOfPerson"="toto"}
     * )
     * @param Request $request
     * @param $name
     * @return Response
     */
    public function indexAction(Request $request, $nameOfPerson){
        $age = $request->get("age") ?? 10;
        return new Response("Hello Symfony $nameOfPerson vous avez $age ans");
    }

    /**
     * @Route("/add/{n1}/{n2}", name="home_add", requirements={"n1"="\d+", "n2"="\d+"})
     * @param $n1
     * @param $n2
     */
    public function addAction($n1, $n2){
        return new Response("la somme de $n1 et $n2 fait ". ($n1 + $n2));
    }

}