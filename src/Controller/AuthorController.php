<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/author")
 * Class AuthorController
 * @package App\Controller
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/list", name="author")
     */
    public function index(AuthorRepository $repository)
    {


        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
            'authorList' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/new")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function newAuthorAction(EntityManagerInterface $em){
        $author = new Author();
        $author->setName("Hugo")
            ->setFirstName("Victor")
            ->setGender("M")
            ->setBirtDate(new \DateTime("now - 170 years"));

        $em->persist($author);
        $em->flush();

        return $this->redirectToRoute("author");
    }


}
