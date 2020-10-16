<?php

namespace App\WeatherService\WeatherDataProvider\OpenWeatherDataProvider;

use App\WeatherService\WeatherDataInterface;
use App\WeatherService\WeatherDataProvider\WeatherDataProviderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenWeatherDataProvider implements WeatherDataProviderInterface
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $apiURL;

    public function __construct(
        HttpClientInterface $httpClient,
        string $apiURL
    )
    {
        $this->httpClient = $httpClient;
        $this->apiURL = $apiURL;
    }

    /**
     * Returns the name of the provider for identification purposes
     *
     * @return string
     */
    public function getProviderName(): string
    {
        return 'openweather';
    }

    /**
     * Provides current weather conditions in a given city
     *
     * @param string $city
     * @param string $apiKey
     * @return WeatherDataInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getWeatherDataForCity(string $city, string $apiKey): WeatherDataInterface
    {
        $response = $this->httpClient->request('GET', $this->apiURL, [
            'query' => [
                'q' => $city,
                'APPID' => $apiKey,
                'units' => 'metric'
            ]
        ]);

        return new OpenWeatherResponseToWeatherDataAdapter($response->toArray());
    }
}