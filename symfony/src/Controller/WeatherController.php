<?php

namespace App\Controller;

use App\Exception\ResponseLoggableException;
use App\WeatherService\WeatherServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class WeatherController extends AbstractAPIController
{
    /**
     * @var WeatherServiceInterface
     */
    private $weatherService;

    public function __construct(WeatherServiceInterface $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * Gets weather data by request query parameters
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function weather(Request $request)
    {
        if(!$request->query->has('api_key') || !$request->query->has('city')) {
            return $this->createErrorResponse(
                422,
                'Either [api_key] or [city] query parameters were not specified!'
            );
        }

        try {
            $weatherData = $this->weatherService->getWeatherDataForCity(
                $request->query->get('city'),
                $request->query->get('api_key')
            );
        } catch(\Exception $exception) {
            return $this->createErrorResponseFromException($exception);
        }

        $normalizer = new ObjectNormalizer();
        return new JsonResponse($normalizer->normalize($weatherData));
    }
}