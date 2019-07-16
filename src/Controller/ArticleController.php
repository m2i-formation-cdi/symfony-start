<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Author;
use App\Form\ArticleFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/list/page-{pageNumber}", name="article",
     *     requirements={"pageNumber"="\d+"}, defaults={"pageNumber"="1"})
     */
    public function index($pageNumber)
    {

        $nbArticlePerPage = 10;
        $repoArticle = $this->em->getRepository(Article::class);
        $repoAuthor = $this->em->getRepository(Author::class);

        $lastArticlesList = $repoArticle->getLastArticles(10);
        $authorList = $repoAuthor->getAuthorList();

        $articleList = $repoArticle->getAllArticlesByPage($nbArticlePerPage, $pageNumber );
        $numberOfArticles = $repoArticle->getTotalNumberOfArticles();
        $nbPages = ceil($numberOfArticles / $nbArticlePerPage);

        $pageNumber = Min($pageNumber, $nbPages);

        $startPage = $pageNumber-5 <0? $pageNumber: $pageNumber-5;
        $endPage = Min($startPage+10, $nbPages);

        return $this->render('article/index.html.twig', [
            "articleList" => $articleList,
            "numberOfArticles" => $numberOfArticles,
            "nbPages" => $nbPages,
            "startPage" => $startPage,
            "endPage" => $endPage,
            "pageNumber" => $pageNumber,
            "lastArticlesList" => $lastArticlesList,
            "authorList" => $authorList
        ]);
    }

    /**
     * @Route("/new", name="article_new")
     * @Route("/edit/{id}", name="article_edit")
     */
    public function addEditArticleAction(Request $request, Article $article=null){

        if(! $article){
            $article = new Article();
        }
        $form = $this->createForm(ArticleFormType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article = $form->getData();
            $this->em->persist($article);
            $this->em->flush();

            return $this->redirectToRoute("article");
        }

        return $this->render("/article/form.html.twig", [
            "articleForm" => $form->createView()
        ]);
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

    /**
     * @param Article $article
     * @Route("/show/{slug}", name="article_show_by_slug")
     * @ParamConverter("article", options={"mapping": {"slug": "slug"} })
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showArticleBySlugAction(Article $article){
        if(! $article){
            throw $this->createNotFoundException("Pas d'article avec cet id");
        }

        return $this->render("article/show.html.twig", ["article"=>$article]);
    }
}
