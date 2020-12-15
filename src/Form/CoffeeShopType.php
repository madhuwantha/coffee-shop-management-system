<?php

namespace App\Form;

use App\Entity\CoffeeShop;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoffeeShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('city')
//            ->add('theme')
//            ->add('menu')
            ->add('owner',EntityType::class,[
                'required' => true,
                'class' => User::class,
                'query_builder' =>function (UserRepository $er) use ($options) {
                    if ($options['data']->getId()){
                        return $er->createQueryBuilder('object')
                            ->andWhere('object.id = :id')
                            ->setParameter('id', $options['data']->getOwner()->getId());
                    }else{
                        return $er->createQueryBuilder('object')
//                            ->setMaxResults(1)
                            ->orderBy('object.id', 'ASC');
                    }
                },
                'choice_label' => function (User $obj) {
                    return sprintf('%s', $obj->getName());
                },
                'placeholder' => ''
            ])
            ->add('reset', ResetType::class)
            ->add('save', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CoffeeShop::class,
        ]);
    }
}
