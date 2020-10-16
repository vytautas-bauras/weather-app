<?php

namespace App\WeatherService\WeatherDataProvider;

use App\WeatherService\WeatherDataInterface;

/**
 * WeatherDataProviderInterface defines an identifiable weather data provider
 * @package App\WeatherService\WeatherDataProvider
 */
interface WeatherDataProviderInterface
{
    /**
     * Returns the name of the provider for identification purposes
     *
     * @return string
     */
    public function getProviderName(): string;

    /**
     * Provides current weather conditions in a given city
     *
     * @param string $city
     * @param string $apiKey
     * @return WeatherDataInterface
     */
    public function getWeatherDataForCity(string $city, string $apiKey): WeatherDataInterface;
}