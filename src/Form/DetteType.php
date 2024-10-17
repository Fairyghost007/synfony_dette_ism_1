<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Dette;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('montant', TextType::class, [
            'label' => 'Montant Total',
            'attr' => [
                'class' => 'border w-full p-2 rounded-lg text-black',
                'placeholder' => 'Montant Totale',

            ],
        ])
        ->add('montantVerser', TextType::class, [
            'label' => 'Montant Verser',
            'attr' => [
                'class' => 'border w-full p-2 rounded-lg text-black',
                'placeholder' => 'Enter le Montant Verser',

            ],
        ])
        ->add('save', SubmitType::class, [
            'label' => 'Ajouter Dette',
            'attr' => ['class' => 'w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600'],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dette::class,
        ]);
    }
}
