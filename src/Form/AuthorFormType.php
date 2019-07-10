<?php


namespace App\Form;


use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("name", TextType::class, ["label"=>"Nom"])
                ->add("firstName", TextType::class, ["label"=>"Prénom", "required"=> false])
                ->add("gender", ChoiceType::class,
                    [
                        "label"=>"Genre",
                        "choices"=> ["féminin" => "f", "masculin"=>"m"],
                        "multiple"=>false, "expanded"=>true,
                        "label_attr"=>[
                            "class"=>"radio-inline"
                        ]
                    ]
                )
                ->add("birthDate", DateType::class, [
                    "label" => "date de naissance",
                    "widget" => "single_text"
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           "data_class" => Author::class
        ]);
    }


}