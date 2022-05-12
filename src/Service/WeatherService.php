<?php

namespace App\Service;

// this class transform the weather code (from API) in picture
class WeatherService 
{
    public function convertWeatherinPicture(int $weather) : string
    {
        if ($weather == 0) {
            $weatherIcon = '/assets/images/Icons/sun.png';
        }
        if ($weather  > 0 && $weather < 7) {
            $weatherIcon = '/assets/images/Icons/cloudy.png';
        }
        if (($weather >= 10 && $weather < 20) 
        || ($weather >=40 && $weather <60)
        || ($weather >= 210)) {
            $weatherIcon = '/assets/images/Icons/cloudyrain.png';
        }
        if ($weather >= 20 && $weather <32
        || ($weather >=61 && $weather <79)) {
            $weatherIcon = '/assets/images/Icons/snowy.png';
        }
        if ($weather >= 100 && $weather <143) {
            $weatherIcon = '/assets/images/Icons/storm.png';
        }
        return $weatherIcon;
    }
}
