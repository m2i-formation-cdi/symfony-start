<?php


namespace App\DataFixtures;


use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        ini_set("memory_limit", "1024M");

        $tags = [
            "PHP", "Politique", "Société",
            "Java", "Humour", "Vacances", "Musique",
            "Base de données", "Art", "Spectacle",
            "Symfony", "Internet"
        ];

        for($i=0; $i<count($tags); $i++){
            $tag = new Tag();
            $tag->setTagName($tags[$i]);
            $manager->persist($tag);

            $this->addReference("tag_". ($i+1), $tag);
        }

        $manager->flush();
    }
}