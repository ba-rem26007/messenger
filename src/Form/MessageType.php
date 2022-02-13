<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // https://symfony.com/doc/current/reference/forms/types.html
        $builder
            ->add('Title', TextType::class, ['label' => 'Titre :'])
            ->add('Body', TextareaType::class, ['label' => 'Contenu du message :'])
            ->add('EmissionDate', DateTimeType::class, [
                'widget' => 'single_text',
                'data' => new \DateTime("now")
                //'html5' => false,
            ])
            //->add('Status')
            //->add('SendingDate')
            ->add('Choice', ChoiceType::class, [
                'label' => 'Type de channel :',
                'choices' => Message::CHOICES,
                //'expanded' => true,
                //'mapped' => false
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
