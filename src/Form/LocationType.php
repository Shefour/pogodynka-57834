<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', null, [
                'attr' => [
                    'placeholder' => 'Enter location name',
                ],
            ])
            ->add('country', CountryType::class)
            ->add('latitude', NumberType::class, [
                'attr' => ['placeholder' => 'Type a latitude (-90.0 to 90.0)', 'min' => -90, 'max' => 90],
            ])
            ->add('longitude', NumberType::class, [
                'attr' => ['placeholder' => 'Type a longitude (-180.0 to 180.0)', 'min' => -180, 'max' => 180],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
