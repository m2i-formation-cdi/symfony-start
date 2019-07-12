<?php


namespace App\Controller;


use App\Entity\Author;
use App\Form\AuthorFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test")
 * Class TestController
 * @package App\Controller
 */
class TestController extends FormCrudController
{
    /**
     * TestController constructor.
     * @param EntityManagerInterface $em
     * @throws \ReflectionException
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
        $this->formEntity = Author::class;
        $this->formTypeClass = AuthorFormType::class;

        $itemClass = new \ReflectionClass($this->formEntity);
        $this->formEntityShortName = $itemClass->getShortName();
        $this->templateDir = strtolower($itemClass->getShortName());
    }
}