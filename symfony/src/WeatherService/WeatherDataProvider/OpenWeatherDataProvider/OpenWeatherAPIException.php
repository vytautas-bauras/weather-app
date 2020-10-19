<?php

namespace App\WeatherService\WeatherDataProvider\OpenWeatherDataProvider;

use App\Exception\ResponseLoggableException;

/**
 * OpenWeatherAPIException is thrown when an error is encountered retrieving weather data from OpenWeatherMap API
 * @package App\WeatherService\WeatherDataProvider\OpenWeatherDataProvider
 */
class OpenWeatherAPIException extends ResponseLoggableException
{

}