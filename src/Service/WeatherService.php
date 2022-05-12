<?php

namespace App\Service;


class WeatherService 
{
    public const OPT = 1.7;
    public const REALIST = 2.4;
    public const PESS = 3.7;

    // this method transform the weather code (from API) in picture
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
    
    public function optimistTemp (int $temperatureMin, int $temperatureMax): array
    {
        $tempMini = $temperatureMin + SELF::OPT * 2;
        $tempMax = $temperatureMax + SELF::OPT * 2;
        $result = [$tempMini, $tempMax];
        return $result;
    }

    public function realistTemp (int $temperatureMin, int $temperatureMax): array
    {
        $tempMini = $temperatureMin + SELF::REALIST * 2;
        $tempMax = $temperatureMax + SELF::REALIST * 2;
        $result = [$tempMini, $tempMax];
        return $result;
    }

    public function pessimistTemp (int $temperatureMin, int $temperatureMax): array
    {
        $tempMini = $temperatureMin + SELF::PESS * 2;
        $tempMax = $temperatureMax + SELF::PESS * 2;
        $result = [$tempMini, $tempMax];
        return $result;
    }
}
