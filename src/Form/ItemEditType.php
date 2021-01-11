<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Item;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ingredients')
            ->add('isInHomePage', CheckboxType::class,['required' => false])
            ->add('name')
            ->add('price')
            ->add('description', TextareaType::class)
            ->add('category', EntityType::class,[
                'required' => true,
                'class' => Category::class,
                'query_builder' =>function (CategoryRepository $er) use ($options) {
                    return $er->createQueryBuilder('object')
                        ->orderBy('object.id', 'ASC');
                },
                'choice_label' => function (Category $obj) {
                    return sprintf('%s', $obj->getName());
                },
                'placeholder' => ''
            ])
            ->add('reset', ResetType::class)
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
