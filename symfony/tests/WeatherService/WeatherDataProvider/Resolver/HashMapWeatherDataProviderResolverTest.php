<?php

namespace App\Tests\WeatherService\WeatherDataProvider\Resolver;

use App\WeatherService\WeatherDataProvider\Resolver\HashMapWeatherDataProviderResolver;
use App\WeatherService\WeatherDataProvider\Resolver\WeatherDataProviderNotFoundException;
use App\WeatherService\WeatherDataProvider\WeatherDataProviderInterface;
use PHPUnit\Framework\TestCase;

class HashMapWeatherDataProviderResolverTest extends TestCase
{
    /**
     * @var HashMapWeatherDataProviderResolver
     */
    private $resolver;

    /**
     * @var WeatherDataProviderInterface
     */
    private $providerStub;

    public function setUp()
    {
        $this->providerStub = $this->createMock(WeatherDataProviderInterface::class);
        $this->providerStub->method('getProviderName')->willReturn('provider');

        $this->resolver = new HashMapWeatherDataProviderResolver([$this->providerStub]);
    }

    public function testResolvesProviderByName()
    {
        $this->assertEquals(
            $this->providerStub,
            $this->resolver->resolve('provider')
        );
    }

    public function testThrowsIfProviderDoesNotExist()
    {
        $this->expectException(WeatherDataProviderNotFoundException::class);
        $this->resolver->resolve('no_such_provider');
    }

    public function testListsAvailableProviders()
    {
        $this->assertEquals(
            ['provider'],
            $this->resolver->getAvailableProviders()
        );
    }
}