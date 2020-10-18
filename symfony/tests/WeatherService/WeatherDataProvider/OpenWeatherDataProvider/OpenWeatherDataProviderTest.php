<?php

namespace App\Tests\WeatherService\WeatherDataProvider\OpenWeatherDataProvider;

use App\WeatherService\WeatherDataProvider\OpenWeatherDataProvider\OpenWeatherAPIException;
use App\WeatherService\WeatherDataProvider\OpenWeatherDataProvider\OpenWeatherDataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class OpenWeatherDataProviderTest extends TestCase
{
    const API_RESPONSE = '{"coord":{"lon":-0.13,"lat":51.51},"weather":[{"id":804,"main":"Clouds","description":"overcast clouds","icon":"04d"}],"base":"stations","main":{"temp":12.47,"feels_like":9.06,"temp_min":11.67,"temp_max":13.33,"pressure":1024,"humidity":58},"visibility":10000,"wind":{"speed":3.1,"deg":50},"clouds":{"all":90},"dt":1602855482,"sys":{"type":1,"id":1414,"country":"GB","sunrise":1602829593,"sunset":1602867907},"timezone":3600,"id":2643743,"name":"London","cod":200}';
    const BAD_API_KEY_API_RESPONSE = '{"cod":401, "message": "Invalid API key. Please see http://openweathermap.org/faq#error401 for more info."}';
    const CITY_NOT_FOUND_API_RESPONSE = '{"cod":"404","message":"city not found"}';

    const API_URL = 'http://api.openweathermap.org/data/2.5/weather';
    const API_KEY = 'ea44eeb65028b1abe04295a49ef1a58b';
    const SAMPLE_CITY = 'London';

    public function testCallsAPIAndAdaptsResponse()
    {
        $callback = function ($method, $url, $options) {
            $this->assertEquals('GET', $method);
            $this->assertEquals(
                'http://api.openweathermap.org/data/2.5/weather?q=London&APPID=ea44eeb65028b1abe04295a49ef1a58b&units=metric',
                $url
            );

            return new MockResponse(self::API_RESPONSE);
        };
        $callback->bindTo($this);

        $client = new MockHttpClient($callback);

        $openWeatherDataProvider = new OpenWeatherDataProvider($client, self::API_URL);
        $weatherData = $openWeatherDataProvider->getWeatherDataForCity(self::SAMPLE_CITY, self::API_KEY);
        $this->assertEquals(12.47, $weatherData->getCurrentTemperature());
    }

    public function testThrowsIfCityNotFound()
    {
        $client = new MockHttpClient(function($method, $url, $options) {
            return new MockResponse(self::CITY_NOT_FOUND_API_RESPONSE, [
                'http_code' => 404
            ]);
        });

        $openWeatherDataProvider = new OpenWeatherDataProvider($client, self::API_URL);
        $this->expectException(OpenWeatherAPIException::class);
        $this->expectExceptionMessage("Weather data for city [London] could not be found using OpenWeatherMap API.");
        $openWeatherDataProvider->getWeatherDataForCity(self::SAMPLE_CITY, self::API_KEY);
    }

    public function testThrowsIfAccessDenied()
    {
        $client = new MockHttpClient(function($method, $url, $options) {
            return new MockResponse(self::BAD_API_KEY_API_RESPONSE, [
                'http_code' => 401
            ]);
        });

        $openWeatherDataProvider = new OpenWeatherDataProvider($client, self::API_URL);
        $this->expectException(OpenWeatherAPIException::class);
        $this->expectExceptionMessage("Access was denied to OpenWeatherMap API. Please verify the API key.");
        $openWeatherDataProvider->getWeatherDataForCity(self::SAMPLE_CITY, self::API_KEY);
    }

    public function testThrowsOnUnknownAPIError()
    {
        $client = new MockHttpClient(function($method, $url, $options) {
            return new MockResponse('', [
                'http_code' => 400
            ]);
        });

        $openWeatherDataProvider = new OpenWeatherDataProvider($client, self::API_URL);
        $this->expectException(OpenWeatherAPIException::class);
        $openWeatherDataProvider->getWeatherDataForCity(self::SAMPLE_CITY, self::API_KEY);
    }
}