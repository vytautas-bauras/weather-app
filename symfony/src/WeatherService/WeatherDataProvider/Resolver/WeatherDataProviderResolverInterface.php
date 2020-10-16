<?php

namespace App\WeatherService\WeatherDataProvider\Resolver;

use App\WeatherService\WeatherDataProvider\WeatherDataProviderInterface;

/**
 * WeatherDataProviderResolverInterface defines the interface for retrieving provider by its name
 * @package App\WeatherService\WeatherDataProvider\Resolver
 */
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