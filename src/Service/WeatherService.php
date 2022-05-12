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

    public function checkData($data): array
    {
        $errors = [];
        if (empty($data)) {
            $errors = 'Vous devez renseigner une ville';
        }
        if (strlen($data) > 80) {
            $errors = 'Votre ville ne peut pas faire plue de 80 caractères';
        }
        return $errors;
    }
    
    public function optimistTemp (int $temperatureMin, int $temperatureMax): array
    {
        $tempMini = $temperatureMin + SELF::OPT * 2;
        $tempMax = $temperatureMax + SELF::OPT * 2;
        $result = [$tempMini, $tempMax];
        return $result;
    }

    public function optimistTemp100 (int $temperatureMin, int $temperatureMax): array
    {
        $tempMini = $temperatureMin + SELF::OPT * 4;
        $tempMax = $temperatureMax + SELF::OPT * 4;
        $result100 = [$tempMini, $tempMax];
        return $result100;
    }

    public function realistTemp (int $temperatureMin, int $temperatureMax): array
    {
        $tempMini = $temperatureMin + SELF::REALIST * 2;
        $tempMax = $temperatureMax + SELF::REALIST * 2;
        $result = [$tempMini, $tempMax];
        return $result;
    }

    public function realistTemp100 (int $temperatureMin, int $temperatureMax): array
    {
        $tempMini = $temperatureMin + SELF::REALIST * 4;
        $tempMax = $temperatureMax + SELF::REALIST * 4;
        $result100 = [$tempMini, $tempMax];
        return $result100;
    }

    public function pessimistTemp (int $temperatureMin, int $temperatureMax): array
    {
        $tempMini = $temperatureMin + SELF::PESS * 2;
        $tempMax = $temperatureMax + SELF::PESS * 2;
        $result = [$tempMini, $tempMax];
        return $result;
    }

    public function pessimistTemp100 (int $temperatureMin, int $temperatureMax): array
    {
        $tempMini = $temperatureMin + SELF::PESS * 6;
        $tempMax = $temperatureMax + SELF::PESS * 6;
        $result100 = [$tempMini, $tempMax];
        return $result100;
    }

    public function temperatureFelt(int $weather, int $actualTemperature) : string
    {
        if ($weather == 0) {
            $actualTemperature = round($actualTemperature * 1.20);
        }
        if ($weather  > 0 && $weather < 7) {
            $actualTemperature = round($actualTemperature * 1);
        }
        if (($weather >= 10 && $weather < 20) 
        || ($weather >=40 && $weather <60)
        || ($weather >= 210)) {
            $actualTemperature = round($actualTemperature * 0.90);
        }
        if ($weather >= 20 && $weather <32
        || ($weather >=61 && $weather <79)) {
            $actualTemperature = round($actualTemperature * 1);
        }
        if ($weather >= 100 && $weather <143) {
            $actualTemperature = round($actualTemperature * 0.80);
        }
        return $actualTemperature;
    }
}
