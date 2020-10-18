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
     * @throws OpenWeatherAPIException
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

        $statusCode = $response->getStatusCode();
        if($statusCode === 401) {
            throw new OpenWeatherAPIException("Access was denied to OpenWeatherMap API. Please verify the API key.");
        } else if($statusCode === 404) {
            throw new OpenWeatherAPIException("Weather data for city [" . $city . "] could not be found using OpenWeatherMap API.");
        } else if($statusCode >= 400) {
            throw new OpenWeatherAPIException("An error occurred trying to get data from OpenWeatherMap API.");
        }

        return new OpenWeatherResponseToWeatherDataAdapter($response->toArray());
    }
}