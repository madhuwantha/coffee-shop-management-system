<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MultipleCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nextCategories',CollectionType::class,[
            'entry_type' => CategoryType::class,
            'entry_options' => ['label' => true],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'label' => false
        ])
            ->add('reset', ResetType::class)
            ->add('save', SubmitType::class);
        ;

    }

}