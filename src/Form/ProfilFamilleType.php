<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ProfilFamilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label'       => 'Prénom *',
                'attr'        => [
                    'placeholder' => 'Votre prénom'
                ],
                'required'    => true,
                'constraints' => new Length(
                    [
                        'min' => 2,
                        'max' => 50
                    ]
                )
            ])
            ->add('lastname', TextType::class, [
                'label'       => 'Nom *',
                'attr'        => [
                    'placeholder' => 'Votre nom'
                ],
                'required'    => true,
                'constraints' => [
                    new Length(
                        [
                            'min' => 2,
                            'max' => 50
                        ]
                    )
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse mail *',
                'attr'  => [
                    'placeholder' => 'Votre adresse mail'
                ],
                'required'    => true
            ])
           
            ->add('code_postal', TextType::class, [
                'label'       => 'Code postal',
                'required'    => false,
                'attr'        => [
                    'placeholder' => 'Votre code postal'
                ]
            ])
            ->add('ville', TextType::class, [
                'label'       => 'Ville',
                'required'    => false,
                'attr'        => [
                    'placeholder' => 'Votre ville'
                ]
            ])
            ->add('telephone', TextType::class, [
                'label'       => 'Téléphone',
                'required'    => false,
                'attr'        => [
                    'placeholder' => 'Votre numéro de téléphone'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label'       => 'Description',
                'required'    => false,
                'attr'        => [
                    'placeholder' => 'Description de la famille'
                ]
            ])

            ->add('register', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
