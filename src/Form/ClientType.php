<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\User;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Correct namespace for SubmitType
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'border w-full p-2 rounded-lg text-black !important',
                    'placeholder' => 'Enter le  nom',
                ],
                'constraints' => [
                    new NotBlank([ 'message' => 'Le nom est obligatoire' ]),
                    // new NotNull( [ 'message' => 'Le nom est obligatoire' ]),
                ],
                'label' => 'Nom:',
                'required' => false,

            ])
            ->add('telephone', TextType::class, [
                'attr' => [
                    'class' => 'border w-full p-2 rounded-lg text-black',
                    'placeholder' => 'Enter le telephone',

                ],
                'constraints' => [
                    new NotBlank([ 'message' => 'Le Telephone est obligatoire' ]),
                    // new NotNull( [ 'message' => 'Le Telephone est non null' ]),
                    new Regex(
                        '/^(77|78|76)([0-9]{7})$/',
                        'Le telephone doit commencer par 77, 78 ou 76 et avoir 9 chiffres'
                    )
                ],
                'label' => 'Telephone:',
                'required' => false,
            ])
            ->add('addresse', TextType::class, [
                'attr' => [
                    'class' => 'border w-full p-2 rounded-lg text-black',
                    'placeholder' => 'Enter l\'addresse',
                ],
                'constraints' => [
                    new NotBlank([ 'message' => 'L\'addresse est obligatoire' ]),
                    // new NotNull( [ 'message' => 'L\'addresse est non null' ]),
                    
                ],
                'label' => 'Addresse:',
                'required' => false,

            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'border w-full p-2 rounded-lg text-black',
                    'placeholder' => 'Enter l\'email',
                ],
                'constraints' => [
                    new NotBlank([ 'message' => 'L\'email est obligatoire' ]),
                    // new NotNull( [ 'message' => 'L\'email est non null' ]),
                    new Regex(
                        '/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
                        'Email doit etre sous la forme xxx@gmail.com'
                    )
                ],  
                'label' => 'Email:',
                'required' => false,
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
