<?php

namespace App\Controller;

use App\Entity\Forecast;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
        WeatherUtil $weatherUtil,
        #[MapQueryParameter] string $format,
        #[MapQueryParameter('twig')] bool $twig = false,
    ): Response
    {
        $forecasts = $weatherUtil->getWeatherForCountryAndCity($country, $city);
        if ($format === 'csv') {
            if ($twig) {
                $response = $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'forecasts' => $forecasts,
                ]);
                $response->headers->set('Content-Type', 'text/plain');
                return $response;
            }
            $rows = array_map(fn(Forecast $m) => sprintf('%s,%s,%s,%s,%s,%s,%s',
                $city,
                $country,
                $m->getDate()->format('Y-m-d'),
                $m->getTemperature(),
                $m->getFahrenheit(),
                $m->getHumidity(),
                $m->getRainChance()), $forecasts);
            array_unshift($rows, 'city,country,date,temperature,fahrenheit,humidity,rainchance'); // Wygenerowane przez AI - Claude Sonnet 5.5
            return new Response(implode("\n", $rows), 200, ['Content-Type' => 'text/csv']);
        }

        if ($format === 'json') {
            if($twig){
                return $this->render('weather_api/index.json.twig', [
                    'city' => $city,
                    'country' => $country,
                    'forecasts' => $forecasts,
                ]);
            }
            return $this->json([
                'city' => $city,
                'country' => $country,
                'forecasts' => array_map(fn(Forecast $m) => [
                    'date' => $m->getDate()->format('Y-m-d'),
                    'temperature' => $m->getTemperature(),
                    'fahrenheit' => $m->getFahrenheit(),
                    'humidity' => $m->getHumidity(),
                    'rainchance' => $m->getRainChance(),
                ], $forecasts),
            ]);
        }

        return $this->json(
            ['error' => 'Unsupported format. Formats supported: json, csv.'],
            Response::HTTP_BAD_REQUEST
        );
    }
}
