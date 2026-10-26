<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\ForecastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    // Część kodu: "requirements: ['id' => '\d+']"
    // została wygenerowana przez LLM Claude Sonnet 5.5
    #[Route('/weather/{id}', name: 'app_weather', requirements: ['id' => '\d+'])]
    public function city(Location $location, ForecastRepository $repository): Response
    {
        $forecasts = $repository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'forecasts' => $forecasts,
//            'controller_name' => 'WeatherController',
        ]);
    }

    #[Route('/weather/{country}/{city}')]
    public function citybyname(
        #[MapEntity(mapping: ['country' => 'country', 'city' => 'city'])]
        Location $location, ForecastRepository $repository
    ): Response {
        $forecasts = $repository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'forecasts' => $forecasts,
        ]);
    }
}
