<?php

namespace App\Tests\WeatherService\ProxyWeatherService;

use App\WeatherService\ProxyWeatherService\ProxyWeatherService;
use App\WeatherService\WeatherDataInterface;
use App\WeatherService\WeatherDataProvider\Resolver\WeatherDataProviderResolverInterface;
use App\WeatherService\WeatherDataProvider\WeatherDataProviderInterface;
use PHPUnit\Framework\TestCase;

class ProxyWeatherServiceTest extends TestCase
{
    public function testProxiesToResolvedProvider()
    {
        $city = 'vilnius';
        $providerName = 'openweather';

        $weatherDataStub = $this->createMock(WeatherDataInterface::class);

        $providerStub = $this->createMock(WeatherDataProviderInterface::class);
        $providerStub->method('getProviderName')->willReturn($providerName);
        $providerStub->method('getWeatherDataForCity')->with($city)->willReturn($weatherDataStub);

        $resolverStub = $this->createMock(WeatherDataProviderResolverInterface::class);
        $resolverStub->expects($this->once())
            ->method('resolve')
            ->with($providerName)
            ->willReturn($providerStub);

        $proxyWeatherService = new ProxyWeatherService($resolverStub);

        $this->assertEquals(
            $weatherDataStub,
            $proxyWeatherService->getWeatherDataForCity($city, $providerName)
        );
    }
}