<?php

namespace App\Controller;

use App\Entity\Forecast;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use App\Service\WeatherUtil;

final class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api', methods: 'GET')]

    public function index(
        #[MapQueryParameter] string $city,
        #[MapQueryParameter] string $country,
        WeatherUtil $weatherUtil
    ): JsonResponse
    {
        $forecasts = $weatherUtil->getWeatherForCountryAndCity($country, $city);

        return $this->json([
            'city' => $city,
            'country' => $country,
            'forecasts' => array_map(fn(Forecast $m) => [
                'date' => $m->getDate()->format('Y-m-d'),
                'temperature' => $m->getTemperature(),
            ], $forecasts),
        ]);
    }
}
