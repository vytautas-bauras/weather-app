<?php

namespace App\WeatherService;

interface WeatherDataInterface
{
    public function getCurrentTemperature(): float;
}