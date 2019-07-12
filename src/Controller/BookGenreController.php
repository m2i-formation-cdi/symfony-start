<?php

namespace App\Controller;

use App\Entity\BookGenre;
use App\Form\BookGenreType;
use App\Repository\BookGenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book/genre")
 */
class BookGenreController extends AbstractController
{
    /**
     * @Route("/", name="book_genre_index", methods={"GET"})
     */
    public function index(BookGenreRepository $bookGenreRepository): Response
    {
        return $this->render('book_genre/index.html.twig', [
            'book_genres' => $bookGenreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="book_genre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bookGenre = new BookGenre();
        $form = $this->createForm(BookGenreType::class, $bookGenre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bookGenre);
            $entityManager->flush();

            return $this->redirectToRoute('book_genre_index');
        }

        return $this->render('book_genre/new.html.twig', [
            'book_genre' => $bookGenre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="book_genre_show", methods={"GET"})
     */
    public function show(BookGenre $bookGenre): Response
    {
        return $this->render('book_genre/show.html.twig', [
            'book_genre' => $bookGenre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="book_genre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BookGenre $bookGenre): Response
    {
        $form = $this->createForm(BookGenreType::class, $bookGenre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('book_genre_index', [
                'id' => $bookGenre->getId(),
            ]);
        }

        return $this->render('book_genre/edit.html.twig', [
            'book_genre' => $bookGenre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="book_genre_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BookGenre $bookGenre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookGenre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bookGenre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('book_genre_index');
    }
}
