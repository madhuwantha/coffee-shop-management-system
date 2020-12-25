<?php

namespace App\Form;

use App\Entity\CoffeeShop;
use App\Entity\Gallery;
use App\Repository\CoffeeShopRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
//            ->add('coffee_shop')
            ->add('coffeeShop',EntityType::class,[
                'required' => true,
                'class' => CoffeeShop::class,
                'query_builder' =>function (CoffeeShopRepository $er) use ($options) {
                    if ($options['data']->getId()){
                        return $er->createQueryBuilder('object')
                            ->andWhere('object.id = :id')
                            ->setParameter('id', $options['data']->getCoffeeShop()->getId());
                    }else{
                        return $er->createQueryBuilder('object')
//                            ->setMaxResults(1)
                            ->orderBy('object.id', 'ASC');
                    }
                },
                'choice_label' => function (CoffeeShop $obj) {
                    return sprintf('%s', $obj->getName());
                },
                'placeholder' => ''
            ])
            ->add('galleryImages',CollectionType::class,[
                'entry_type' => GalleryImageType::class,
                'entry_options' => ['label' => true],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false
            ])
            ->add('galleryVideos',CollectionType::class,[
                'entry_type' => GalleryVideoType::class,
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gallery::class,
        ]);
    }
}
