<?php

namespace App\Form;

use App\Entity\CoffeeShop;
use App\Entity\Theme;
use App\Entity\User;
use App\Repository\ThemeRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoffeeShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('openHours', CollectionType::class,[
                'entry_type' => OpenHourType::class,
                'entry_options' => ['label' => true],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false
            ])
            ->add('theme',EntityType::class,[
                'required' => true,
                'class' => Theme::class,
                'query_builder' => function (ThemeRepository $er) use ($options) {
                    return $er->createQueryBuilder('object')
                        ->orderBy('object.id', 'ASC');
                },
                'choice_label' => function (Theme $obj) {
                    return sprintf('%s', $obj->getName());
                },
                'placeholder' => ''
            ])
            ->add('name')
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'tinymce',
                    'data' => 'abcdef',
                ],
            ])
            ->add('aboutUs', TextareaType::class)
            ->add('sliderImages', CollectionType::class, [
                'entry_type' => SliderImageType::class,
                'entry_options' => ['label' => true],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false
            ])
            ->add('contactDetail', ContactDetailsType::class, ['required' => true,'label' => false])
            ->add('coverPhoto', CoverPhotoType::class, ['required' => false,'label' => false])
            ->add('menu', MenuType::class, ['required' => true,'label' => false])
            ->add('owner', EntityType::class, [
                'required' => true,
                'class' => User::class,
                'query_builder' => function (UserRepository $er) use ($options) {
                    return $er->createQueryBuilder('object')
                        ->orderBy('object.id', 'ASC');
                },
                'choice_label' => function (User $obj) {
                    return sprintf('%s', $obj->getName());
                },
                'placeholder' => ''
            ])
            ->add('reset', ResetType::class)
            ->add('save', SubmitType::class);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CoffeeShop::class,
        ]);
    }
}
