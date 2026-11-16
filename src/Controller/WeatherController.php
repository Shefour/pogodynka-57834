<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\ForecastRepository;
Use App\Service\WeatherUtil;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    // Część kodu: "requirements: ['id' => '\d+']"
    // została wygenerowana przez LLM Claude Sonnet 5.5
    #[Route('/weather/{id}', name: 'app_weather', requirements: ['id' => '\d+'])]
    public function city(Location $location, WeatherUtil $util): Response
    {
        $forecasts = $util->getWeatherForLocation($location);
        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'forecasts' => $forecasts,
//            'controller_name' => 'WeatherController',
        ]);
    }

    #[Route('/weather/{country}/{city}')]
    public function citybyname(
        string $country,
        string $city,
        #[MapEntity(mapping: ['country' => 'country', 'city' => 'city'])]
        Location $location,
        WeatherUtil $util,
    ): Response {
        $forecasts = $util->getWeatherForCountryAndCity($country, $city);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'forecasts' => $forecasts,
        ]);
    }
}
