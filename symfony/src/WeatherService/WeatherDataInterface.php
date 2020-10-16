<?php

namespace App\WeatherService;

/**
 * WeatherDataInterface defines the common interface for weather data representation
 * @package App\WeatherService
 */
interface WeatherDataInterface
{
    /**
     * The current temperature in the area
     *
     * @return float
     */
    public function getCurrentTemperature(): float;
}