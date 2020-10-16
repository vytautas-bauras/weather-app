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

    public function getWeatherDataForCity(string $city, string $provider = null): WeatherDataInterface
    {
        $provider = $this->providerResolver->resolve($provider);

        return $provider->getWeatherDataForCity($city);
    }
}