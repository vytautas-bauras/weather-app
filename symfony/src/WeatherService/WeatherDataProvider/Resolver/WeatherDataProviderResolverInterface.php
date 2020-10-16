<?php

namespace App\WeatherService\WeatherDataProvider\Resolver;

use App\WeatherService\WeatherDataProvider\WeatherDataProviderInterface;

interface WeatherDataProviderResolverInterface
{
    /**
     * Returns a provider associated with the given name
     *
     * @param string $providerName
     * @return WeatherDataProviderInterface
     * @throws WeatherDataProviderNotFoundException
     */
    public function resolve(string $providerName): WeatherDataProviderInterface;
}