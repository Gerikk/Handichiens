<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label'       => 'Prénom',
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
                'label'       => 'Nom',
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
                'label' => 'Adresse mail',
                'attr'  => [
                    'placeholder' => 'Votre adresse mail'
                ],
                'required'    => true
            ])
            ->add('password', RepeatedType::class, [
                'type'            => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques.',
                'required'        => true,
                'constraints' => [
                    new Length(
                        [ 'min' => 8 ]
                    ),
                    new Regex(
                        [ 'pattern' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/' ]
                    ),
                ],
                'first_options'   => [
                    'label' => 'Mot de passe',
                    'attr'  => ['placeholder' => 'Votre mot de passe',
                                'class'=>'form-control']
                ],
                'second_options'  => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr'  => ['placeholder' => 'Merci de confirmer votre mot de passe',
                                'class'=>'form-control']
                ]
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
            ->add('photos', FileType::class, [
                'label' => 'Photo de profil (.jpg, .png)',
                'mapped' => false,
                // make it optional so you don't have to re-upload the photo
                // every time you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Veuillez ajouter une image au format .jpg ou .png',
                    ])
                ],
            ])
            ->add('register', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
