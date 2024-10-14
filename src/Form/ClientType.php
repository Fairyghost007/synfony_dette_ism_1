<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Correct namespace for SubmitType
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'border w-full p-2 rounded-lg text-black !important'],
                'label' => 'Nom:',
            ])
            ->add('telephone', TextType::class, [
                'attr' => ['class' => 'border w-full p-2 rounded-lg text-black'],
                'label' => 'Telephone:',
            ])
            ->add('addresse', TextType::class, [
                'attr' => ['class' => 'border w-full p-2 rounded-lg text-black'],
                'label' => 'Addresse:',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save',
                'attr' => ['class' => 'w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
