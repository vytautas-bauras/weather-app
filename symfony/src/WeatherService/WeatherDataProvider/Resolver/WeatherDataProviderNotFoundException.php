<?php

namespace App\WeatherService\WeatherDataProvider\Resolver;

use Throwable;

class WeatherDataProviderNotFoundException extends \Exception
{
    public function __construct(string $providerName)
    {
        parent::__construct("Provider named [" . $providerName . "] could not be resolved!");
    }
}