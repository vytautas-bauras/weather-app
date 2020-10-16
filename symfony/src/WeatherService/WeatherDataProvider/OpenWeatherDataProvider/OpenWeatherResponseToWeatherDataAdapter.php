<?php

namespace App\WeatherService\WeatherDataProvider\OpenWeatherDataProvider;

use App\WeatherService\WeatherDataInterface;

/**
 * OpenWeatherResponseToWeatherDataAdapter adapts the response received from OpenWeather api to WeatherDataInterface
 * @package App\WeatherService\WeatherDataProvider\OpenWeatherDataProvider
 */
class OpenWeatherResponseToWeatherDataAdapter implements WeatherDataInterface
{
    /**
     * @var array
     */
    private $openWeatherResponse;

    public function __construct(array $openWeatherResponse)
    {
        $this->openWeatherResponse = $openWeatherResponse;
    }

    /**
     * The current temperature in the area
     *
     * @return float
     */
    public function getCurrentTemperature(): float
    {
        return $this->openWeatherResponse['main']['temp'];
    }
}