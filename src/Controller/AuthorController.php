<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorFormType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/new", name="author_new")
     * @Route("/edit/{id}", name="author_edit")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function addEditAuthorAction(
        EntityManagerInterface $em,
        Request $request,
        AuthorRepository $repository,
        $id=null)
    {

        if($id){
            $buttonLabel = "Modifier";
            $author = $repository->findOneBy(["id"=>$id]);
        } else {
            $author = new Author();
            $buttonLabel = "Ajouter";
        }

        dump($author);

        $form = $this->createForm(AuthorFormType::class, $author);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $author = $form->getData();

            $this->addFlash("success", "Votre auteur a été ajouté");
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute("author");
        }

        return $this->render("/author/form.html.twig",
            [
                "authorForm" => $form->createView(),
                "buttonLabel" => $buttonLabel
            ]);
    }

    /**
     * @Route("/delete/{id}", name="author_delete")
     * @param EntityManagerInterface $em
     * @param Author $author
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAuthor(EntityManagerInterface $em, Author $author){
        $em->remove($author);
        $em->flush();

        $this->addFlash("success", "Suppression ok");

        return $this->redirectToRoute("author");

    }



}
