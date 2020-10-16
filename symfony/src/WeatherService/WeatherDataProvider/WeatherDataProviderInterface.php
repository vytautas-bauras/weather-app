<?php

namespace App\WeatherService\WeatherDataProvider;

use App\WeatherService\WeatherDataInterface;

interface WeatherDataProviderInterface
{
    public function getProviderName();
    public function getWeatherDataForCity(string $city): WeatherDataInterface;
}