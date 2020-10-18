<?php

namespace App\WeatherService\ProxyWeatherService;

use App\WeatherService\WeatherDataInterface;
use App\WeatherService\WeatherDataProvider\Resolver\WeatherDataProviderResolverInterface;
use App\WeatherService\WeatherServiceInterface;

/**
 * ProxyWeatherService directly proxies weather data requests to specified provider
 * @package App\WeatherServiceInterface\ProxyWeatherService
 */
class ProxyWeatherService implements WeatherServiceInterface
{
    /**
     * @var WeatherDataProviderResolverInterface
     */
    private $providerResolver;

    public function __construct(WeatherDataProviderResolverInterface $providerResolver)
    {
        $this->providerResolver = $providerResolver;
    }

    /**
     * Proxies the request to the specified provider and forwards the data
     *
     * @param string $city
     * @param string $apiKey
     * @param string|null $providerName
     * @return WeatherDataInterface
     * @throws \App\WeatherService\WeatherDataProvider\Resolver\WeatherDataProviderNotFoundException
     */
    public function getWeatherDataForCity(string $city, string $apiKey, string $providerName = null): WeatherDataInterface
    {
        $providerName = $providerName ?? $this->providerResolver->getAvailableProviders()[0];
        $provider = $this->providerResolver->resolve($providerName);

        return $provider->getWeatherDataForCity($city, $apiKey);
    }
}