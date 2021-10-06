<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Chien;
use App\Repository\ChienRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffectationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('chien_id', EntityType::class,
                  [
                      'class'=>Chien::class,
                      'query_builder' => function (ChienRepository $er) {
                          return $er->createQueryBuilder('u')
                              ->select('u')
                              ->leftJoin('App\Entity\Booking', 'booking', 'With', 'u.id = booking.chien_id')
                              ->where('booking.chien_id is Null')
                              ;
                      },
                      'choice_label' => 'name',
                      'placeholder' => 'Chiens restants',
                      'label'=>'Veuillez sélectionner le chien à attribuer : ',
                      'attr'=>[
                          'class'=>'form-select dog-attribution'
                      ]
                  ]
            )

            ->add("register", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
