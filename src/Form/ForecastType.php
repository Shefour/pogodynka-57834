<?php

namespace App\Form;

use App\Entity\Forecast;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Repository\LocationRepository;

class ForecastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class)
            ->add('temperature', IntegerType::class, [
                'label' => 'Temperature in °C',
            ])
            ->add('rainchance', IntegerType::class, [
                'label' => 'Chance of rain as percentage',
                'attr' => ['min' => 0, 'max' => 100],
            ])
            ->add('windspeed', IntegerType::class, [
                'label' => 'Wind speed in km/h',
                'attr' => ['min' => 0],
            ])
            ->add('humidity', IntegerType::class, [
                'label' => 'Humidity as percentage',
                'attr' => ['min' => 0, 'max' => 100],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' =>
                    fn (Location $location) => sprintf('%s, %s (ID: %d)',
                        $location->getCity(),
                        $location->getCountry(),
                        $location->getID())
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forecast::class,
        ]);
    }
}
