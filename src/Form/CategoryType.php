<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Menu;
use App\Repository\MenuRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('level')
            ->add('menu', EntityType::class,[
                'required' => true,
                'class' => Menu::class,
                'query_builder' =>function (MenuRepository $er) use ($options) {
                        return $er->createQueryBuilder('object')
                            ->orderBy('object.id', 'ASC');
                },
                'choice_label' => function (Menu $obj) {
                    return sprintf('%s', $obj->getName());
                },
                'placeholder' => ''
            ])
//            ->add('subcategory')
//            ->add('items',CollectionType::class,[
//                'entry_type' => ItemType::class,
//                'entry_options' => ['label' => true],
//                'allow_add' => true,
//                'allow_delete' => true,
//                'by_reference' => false,
//                'label' => false
//            ])
            ->add('reset', ResetType::class)
            ->add('save', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
