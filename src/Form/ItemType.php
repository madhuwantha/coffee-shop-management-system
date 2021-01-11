<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ingredients')
            ->add('isInHomePage', CheckboxType::class,['required' => false])
            ->add('name')
            ->add('price')
            ->add('description', TextareaType::class)
//            ->add('itemImages',CollectionType::class,[
//                'entry_type' => ItemImageType::class,
//                'entry_options' => ['label' => true],
//                'allow_add' => true,
//                'allow_delete' => true,
//                'by_reference' => false,
//                'label' => false
//            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
