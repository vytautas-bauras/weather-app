<?php

namespace App\WeatherService;

/**
 * WeatherServiceInterface defines the methods for retrieving weather data
 * @package App\WeatherService
 */
interface WeatherServiceInterface
{
    /**
     * Returns weather data for a given city using the specified provider
     *
     * @param string $city
     * @param string|null $provider
     * @return WeatherDataInterface
     */
    public function getWeatherDataForCity(string $city, string $provider = null): WeatherDataInterface;
}