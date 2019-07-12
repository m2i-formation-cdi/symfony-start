<?php


namespace App\DataFixtures;


use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create("us_US");

        for($i=1; $i<= 500; $i++){
            $createdAt = $faker->dateTimeThisDecade();

            $article = new Article();
            $article->setTitle($faker->sentence(8))
                ->setContent($faker->paragraphs(5, true))
                ->setCreatedAt($createdAt)
                ->setUpdatedAt($faker->dateTimeBetween($createdAt))
                ->setAuthor($this->getReference("author_".mt_rand(0, 25)));

            $manager->persist($article);

        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            AuthorFixtures::class
        ];
    }
}