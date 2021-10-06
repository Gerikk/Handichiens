<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beginAt', DateTimeType::class,
                  [
                      'label' => 'Date de début',
                      'required' => true,
                      'widget' => 'choice',
                      'date_format' => 'ddMMMMy',
                      'years' => range(date('Y'), date('Y')),
                      'data' => new \DateTime('now +2 hour'),
                      'attr' => ['class' => 'booking-select']
                  ])
            ->add('endAt', DateTimeType::class,
                  [
                      'label' => 'Date de fin',
                      'required' => true,
                      'widget' => 'choice',
                      'date_format' => 'ddMMMMy',
                      'years' => range(date('Y'), date('Y')),
                      'data' => new \DateTime('now +1 day +2 hour'),
                      'attr' => ['class' => 'booking-select']
                  ])
            ->add('title', TextType::class,
                [
                    'label'=>'Titre',
                    'required'=> true,
                    'attr'=>['class'=>'form-control mb-3']
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
