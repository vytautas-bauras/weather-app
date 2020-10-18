<?php

namespace App\Tests\WeatherService\ProxyWeatherService;

use App\WeatherService\ProxyWeatherService\ProxyWeatherService;
use App\WeatherService\WeatherDataInterface;
use App\WeatherService\WeatherDataProvider\Resolver\WeatherDataProviderResolverInterface;
use App\WeatherService\WeatherDataProvider\WeatherDataProviderInterface;
use PHPUnit\Framework\TestCase;

class ProxyWeatherServiceTest extends TestCase
{
    const SAMPLE_CITY = 'vilnius';
    const SAMPLE_API_KEY = 'api2key';
    const SAMPLE_PROVIDER = 'openweather';

    public function testProxiesToResolvedProvider()
    {
        $weatherDataStub = $this->createMock(WeatherDataInterface::class);

        $providerStub = $this->createMock(WeatherDataProviderInterface::class);
        $providerStub->method('getWeatherDataForCity')->with(self::SAMPLE_CITY, self::SAMPLE_API_KEY)->willReturn($weatherDataStub);

        $resolverStub = $this->createMock(WeatherDataProviderResolverInterface::class);
        $resolverStub->method('resolve')
            ->with(self::SAMPLE_PROVIDER)
            ->willReturn($providerStub);

        $resolverStub->method('getAvailableProviders')->willReturn([self::SAMPLE_PROVIDER]);

        $proxyWeatherService = new ProxyWeatherService($resolverStub);

        $this->assertEquals(
            $weatherDataStub,
            $proxyWeatherService->getWeatherDataForCity(self::SAMPLE_CITY, self::SAMPLE_API_KEY, self::SAMPLE_PROVIDER)
        );

        $this->assertEquals(
            $weatherDataStub,
            $proxyWeatherService->getWeatherDataForCity(self::SAMPLE_CITY, self::SAMPLE_API_KEY),
            'Proxy service could not get weather data by selecting a default provider.'
        );

        return $proxyWeatherService;
    }
}