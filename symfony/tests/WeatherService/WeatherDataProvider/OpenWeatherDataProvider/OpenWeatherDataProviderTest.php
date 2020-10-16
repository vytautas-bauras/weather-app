<?php

namespace App\Tests\WeatherService\WeatherDataProvider\OpenWeatherDataProvider;

use App\WeatherService\WeatherDataProvider\OpenWeatherDataProvider\OpenWeatherDataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class OpenWeatherDataProviderTest extends TestCase
{
    const API_RESPONSE = '{"coord":{"lon":-0.13,"lat":51.51},"weather":[{"id":804,"main":"Clouds","description":"overcast clouds","icon":"04d"}],"base":"stations","main":{"temp":12.47,"feels_like":9.06,"temp_min":11.67,"temp_max":13.33,"pressure":1024,"humidity":58},"visibility":10000,"wind":{"speed":3.1,"deg":50},"clouds":{"all":90},"dt":1602855482,"sys":{"type":1,"id":1414,"country":"GB","sunrise":1602829593,"sunset":1602867907},"timezone":3600,"id":2643743,"name":"London","cod":200}';

    public function testCallsAPIAndAdaptsResponse()
    {
        $apiURL = 'http://api.openweathermap.org/data/2.5/weather';
        $apiKey = 'ea44eeb65028b1abe04295a49ef1a58b';
        $city = 'London';

        $callback = function ($method, $url, $options) use ($apiURL, $apiKey, $city) {
            $this->assertEquals('GET', $method);
            $this->assertEquals(
                'http://api.openweathermap.org/data/2.5/weather?q=London&APPID=ea44eeb65028b1abe04295a49ef1a58b&units=metric',
                $url
            );

            return new MockResponse(self::API_RESPONSE);
        };
        $callback->bindTo($this);

        $client = new MockHttpClient($callback);

        $openWeatherDataProvider = new OpenWeatherDataProvider($client, $apiURL);
        $weatherData = $openWeatherDataProvider->getWeatherDataForCity($city, $apiKey);
        $this->assertEquals(12.47, $weatherData->getCurrentTemperature());
    }
}