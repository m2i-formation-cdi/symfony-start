<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Author;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 * Class ArticleController
 * @package App\Controller
 */
class ArticleController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ArticleController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("/list", name="article")
     */
    public function index()
    {

        $repo = $this->em->getRepository(Article::class);
        $articleList = $repo->findAll();

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            "articleList" => $articleList
        ]);
    }

    /**
     * @Route("/new")
     */
    public function newArticleAction(){
        $article = new Article();

        $author = new Author();
        $author->setName("Hemingway")
            ->setFirstName("Ernest")
            ->setGender("m")
            ->setBirtDate(new \DateTime("now +15 days -100 years"));

        $article->setTitle('Pour qui sonne le glas')
            ->setContent('et il va faire mal')
            ->setCreatedAt(new \DateTime('now -15 minutes'))
            ->setUpdatedAt(new \DateTime('now'))
            ->setAuthor($author);


        $entityManager = $this->em;

        $entityManager->persist($article);
        $entityManager->flush();



        return $this->redirectToRoute("article");
    }

    /**
     * @Route("/show/{id}", name="article_show", requirements={"id"="\d+"})
     * @param $id
     */
    public function showArticleAction(Article $article){
        //$repo = $this->em->getRepository(Article::class);
        //$article = $repo->findOneBy(["id"=>$id]);

        if(! $article){
            throw $this->createNotFoundException("Pas d'article avec cet id");
        }

        return $this->render("article/show.html.twig", ["article"=>$article]);
    }
}
