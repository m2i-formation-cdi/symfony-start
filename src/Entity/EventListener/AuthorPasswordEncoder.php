<?php


namespace App\Entity\EventListener;


use App\Entity\Author;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthorPasswordEncoder
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AuthorPasswordEncoder constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function prePersist(LifecycleEventArgs $args){
        $user = $args->getObject();

        if(! $user instanceof Author){
            return;
        }

        $user->setPassword($this->encoder->encodePassword($user,$user->getPlainPassword()));
        $user->setPlainPassword(null);
    }

}