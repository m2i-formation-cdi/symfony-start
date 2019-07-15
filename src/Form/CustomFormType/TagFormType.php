<?php


namespace App\Form\CustomFormType;


use App\Form\DataTransformer\TagDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TagFormType extends AbstractType
{
    /**
     * @var TagDataTransformer
     */
    private $transformer;

    /**
     * TagFormType constructor.
     * @param TagDataTransformer $transformer
     */
    public function __construct(TagDataTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->transformer);
    }


}