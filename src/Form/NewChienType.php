<?php

namespace App\Form;

use App\Entity\Chien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NewChienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('name', TextType::class, ['required'=>true])
            ->add('age', NumberType::class, ['required'=>true])
            ->add('race', TextType::class, ['required'=>true])
            ->add('formation', TextType::class, ['required'=>true])
            ->add('resume', TextareaType::class, ['required'=>true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chien::class,
        ]);
    }
}
