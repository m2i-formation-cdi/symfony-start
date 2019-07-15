<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Author;
use App\Form\DataTransformer\TagDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    /**
     * @var TagDataTransformer
     */
    private $transformer;

    /**
     * ArticleFormType constructor.
     * @param TagDataTransformer $transformer
     */
    public function __construct(TagDataTransformer $transformer)
    {
        $this->transformer = $transformer;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ["label"=> "titre"])
            ->add('content', TextareaType::class, ["label" => "Contenu",
                "attr" => ["rows"=>10, "cols"=>"25"]
            ])
            ->add('author', EntityType::class,
                [
                    "label"=>"Auteur",
                    "class"=> Author::class,
                    "choice_label" => "fullName"
                ])
            ->add('tags', TextType::class, ['label'=>'tags'])
        ;

        $builder->get('tags')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
