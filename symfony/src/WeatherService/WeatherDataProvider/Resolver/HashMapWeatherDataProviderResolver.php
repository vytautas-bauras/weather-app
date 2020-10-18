<?php

namespace App\WeatherService\WeatherDataProvider\Resolver;

use App\WeatherService\WeatherDataProvider\WeatherDataProviderInterface;

/**
 * HashMapWeatherDataProviderResolver resolves weather data providers using an internal hash map
 * @package App\WeatherService\WeatherDataProvider
 */
class HashMapWeatherDataProviderResolver implements WeatherDataProviderResolverInterface
{
    private $providerMap = [];

    /**
     * @param WeatherDataProviderInterface[] $providers
     */
    public function __construct(iterable $providers)
    {
        foreach($providers as $provider) {
            $this->providerMap[$provider->getProviderName()] = $provider;
        }
    }

    /**
     * Returns provider associated with a given name and throws if the provider could not be found
     *
     * @param string $providerName
     * @return WeatherDataProviderInterface
     * @throws WeatherDataProviderNotFoundException
     */
    public function resolve(string $providerName): WeatherDataProviderInterface
    {
        if(!isset($this->providerMap[$providerName])) {
            throw new WeatherDataProviderNotFoundException($providerName);
        }

        return $this->providerMap[$providerName];
    }

    public function getAvailableProviders()
    {
        return array_keys($this->providerMap);
    }
}