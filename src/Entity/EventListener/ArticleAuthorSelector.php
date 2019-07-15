<?php


namespace App\Entity\EventListener;


use App\Entity\Article;
use App\Repository\AuthorRepository;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class ArticleAuthorSelector
{


    /**
     * @var AuthorRepository
     */
    private $repository;

    /**
     * ArticleAuthorSelector constructor.
     * @param AuthorRepository $repository
     */
    public function __construct(AuthorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function prePersist(LifecycleEventArgs $args){
        $entity = $args->getObject();

        if(! $entity instanceof Article){
            return;
        }

        $author = $this->repository->findOneBy([
            "name" => $entity->getAuthor()->getName(),
            "firstName" => $entity->getAuthor()->getFirstName()
        ]);

        if($author){
            $entity->setAuthor($author);
        }
    }
}