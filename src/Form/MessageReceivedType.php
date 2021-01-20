<?php


namespace App\Form;


use App\Entity\MessageReceived;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageReceivedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message',TextareaType::class,['required' => true])
            ->add('reciever', EntityType::class, [
                'required' => true,
                'class' => User::class,
                'query_builder' => function (UserRepository $er) use ($options) {
                    return $er->createQueryBuilder('object')
                        ->orderBy('object.id', 'ASC');
                },
                'choice_label' => function (User $obj) {
                    return sprintf('%s', $obj->getName());
                },
                'placeholder' => 'Receiver'
            ])
            ->add('Send', SubmitType::class);;
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MessageReceived::class,
        ]);
    }

}