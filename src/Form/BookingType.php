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
                      'placeholder' => '...',
                      'required' => true,
                      'widget' => 'choice',
                      //'format' => 'ddMMy',
                      'years' => range(date('Y'), date('Y') + 5),
                      'data' => new \DateTime(),
                      'attr' => ['class' => 'form-control']
                  ])
            ->add('endAt', DateTimeType::class,
                  [
                      'label' => 'Date de fin',
                      'placeholder' => '...',
                      'required' => false,
                      'widget' => 'choice',
                      //'format' => 'ddMMy',
                      'years' => range(date('Y'), date('Y') + 5),
                      'data' => new \DateTime(),
                      'attr' => ['class' => 'form-control']
                  ])
            ->add('title', TextType::class,
                  [
                      'label'=>'Titre',
                      //'placeholder' => 'Entrez un nom',
                      'required' => true,
                      'attr' => ['class' => 'form-control mb-3']
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
