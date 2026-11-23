<?php

namespace App\Tests\Entity;

use App\Entity\Forecast;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ForecastTest extends TestCase
{
    public static function dataGetFahrenheit(): array
    {
        return [
            ['0', '32'],
            ['-100', '-148'],
            ['100', '212'],
            ['0.5', '32'],
            ['-0.5', '31'],
            ['10.1', '50'],
            ['-20.2', '-4'],
            ['30.3', '86'],
            ['-40.4', '-40'],
            ['50.5', '122'],
        ];
    }

    #[DataProvider('dataGetFahrenheit')]
    public function testGetFahrenheit(string $temp, string $expectedFahrenheit): void
    {
        $forecast = new Forecast();
        $forecast->setTemperature((float) $temp);

        $this->assertSame($expectedFahrenheit, (string) $forecast->getFahrenheit());
    }
}
