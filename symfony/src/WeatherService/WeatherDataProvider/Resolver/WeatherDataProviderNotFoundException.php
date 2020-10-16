<?php

namespace App\WeatherService\WeatherDataProvider\Resolver;

use Throwable;

/**
 * WeatherDataProviderNotFoundException is thrown when a provider could not be resolved for a given name
 * @package App\WeatherService\WeatherDataProvider\Resolver
 */
class WeatherDataProviderNotFoundException extends \Exception
{
    public function __construct(string $providerName)
    {
        parent::__construct("Provider named [" . $providerName . "] could not be resolved!");
    }
}