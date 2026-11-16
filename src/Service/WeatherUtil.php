<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Forecast;
use App\Repository\LocationRepository;

class WeatherUtil
{

    // Konstruktor dla locationRepository wygenerowany przez Claude Sonnet 5.5
    public function __construct(private readonly LocationRepository $locationRepository)
    {
    }

    /**
     * @return Forecast[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        $collection = $location->getForecasts();
        return $collection->toArray();

//        return [];
    }

    /**
     * @param string $country
     * @param string $city
     * @return Forecast[]
     */
    public function getWeatherForCountryAndCity(string $country, string $city): array
    {
        $location = $this->locationRepository->findOneBy([
            'country' => $country,
            'city' => $city,
        ]);

        return $this->getWeatherForLocation($location);
    }
}
