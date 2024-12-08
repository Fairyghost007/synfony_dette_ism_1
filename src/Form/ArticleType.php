<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'attr' => ['class' => 'border w-full p-2 rounded-lg '],
                'label' => 'Libelle',
            ])
            ->add('prix', NumberType::class, [
                'attr' => ['class' => 'border w-full p-2 rounded-lg '],
                'label' => 'Prix',
                'scale' => 2, 
            ])
            ->add('qteStock', NumberType::class, [
                'attr' => ['class' => 'border w-full p-2 rounded-lg '],
                'label' => 'Quantity in Stock',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'save',
                'attr' => ['class' => 'w-full bg-blue-500 text-white py-3 px-5  mt-0 rounded hover:bg-blue-600'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
