<?php

namespace App\Service;

class WeatherService 
{
    public function convertWeather(int $weather) : int
    {
        if ($weather == 0) {
            $weatherIcon = //soleil
        }
        if ($weather  > 0 && $weather < 7) {
            $weatherIcon = // nuage
        }
        if (($weather >= 10 && $weather < 20) 
        || ($weather >=40 && $weather <60)
        || ($weather >= 210)) {
            $weatherIcon = // pluie
        }
        if ($weather >= 20 && $weather <32
        || ($weather >=61 && $weather <79)) {
            $weatherIcon = // neige
        }
        if ($weather >= 100 && $weather <143) {
            $weatherIcon = // orage
        }
    }
}
