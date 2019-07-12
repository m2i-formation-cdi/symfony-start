<?php


namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

abstract class FormCrudController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Entity
     */
    public $formEntity;

    /**
     * @var string
     */
    public $formEntityShortName;

    /**
     * @var AbstractType
     */
    public $formTypeClass;

    /**
     * @var string
     */
    public $templateDir;

    /**
     * FormCrudService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/showAll", name="show_all")
     * @return Response
     */
    public function showAllAction() {
        $repo = $this->getDoctrine()->getRepository($this->formEntity);
        $itemList = $repo->findAll();

        return $this->render($this->templateDir.'/index.html.twig', [
            'authorList' => $itemList
        ]);

    }

    /**
     * @Route("/show/{id}",
     *         name="show_one",
     *         requirements={"id"="\d*"})
     * @param $id
     * @return Response
     */
    public function showOneAction($id) {
        try {
            $repository = $this->getDoctrine()->getRepository($this->formEntity);
            $item = $repository->findOneById($id);
            return $this->render($this->templateDir."/show.html.twig", ['author' => $item]);
        } catch (NotFoundHttpException $ex) {
            throw $this->createNotFoundException("No author found for this id!\n" . $ex);
        }
    }

    /**
     * @Route("/add", name="add_one")
     * @Route("/edit/{id}", name="edit_one")
     * @param Request $request
     * @param int|null $id
     * @return RedirectResponse|Response
     * @throws \ReflectionException
     */
    public function addOneAction(Request $request, int $id = null) {
        $repository = $this->getDoctrine()->getRepository($this->formEntity);
        if($id) {
            $item = $repository->findOneById($id);
            $action = "Modify";
        }
        else
        {
            $itemClass = new \ReflectionClass($this->formEntity);
            $item = $itemClass->newInstance();
            $action = "Add";
        }

        $form = $this->createForm($this->formTypeClass, $item);

        $request->attributes->add(["modify" => $item]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();

            if ($id) {
                $this->addFlash("success", "New ".$this->templateDir." changed successfully!");
            } else {
                $this->addFlash("success", "New ".$this->templateDir." added successfully!");
            }

            $this->em->persist($author);
            $this->em->flush();

            return $this->redirectToRoute("show_all");
        }

        return $this->render($this->templateDir."/form.html.twig", ["authorForm" => $form->createView(), "buttonLabel" => $action]);
    }

    /**
     * @Route("/del/{id}", name="del_one")
     * @param $id
     * @return RedirectResponse
     */
    public function delOneAction($id) {
        $repository = $this->getDoctrine()->getRepository($this->formEntity);
        $item = $repository->findOneById($id);

        $this->em->remove($item);
        $this->em->flush();

        $this->addFlash("success", $this->formEntityShortName." deleted successfully!");
        return $this->redirectToRoute("show_all");
    }
}