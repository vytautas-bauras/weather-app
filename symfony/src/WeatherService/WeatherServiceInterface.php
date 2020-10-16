<?php

namespace App\WeatherService;

interface WeatherServiceInterface
{
    public function getWeatherDataForCity(string $city, string $provider = null): WeatherDataInterface;
}