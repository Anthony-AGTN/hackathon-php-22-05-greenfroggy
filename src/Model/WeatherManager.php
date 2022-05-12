<?php

namespace App\Model;
use Symfony\Component\HttpClient\HttpClient;

class WeatherManager extends AbstractManager
{
    public function getLocationByName(string $name){
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://api.meteo-concept.com/api/location/cities?token=7293fdc8b49b1840699c627230378b0b5b997958488983649eaf0ebd089fc852&search=' . $name);
        return $response->toArray();
    }

    public function getWeatherByInsee (string $insee){
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.meteo-concept.com/api/forecast/daily?token=7293fdc8b49b1840699c627230378b0b5b997958488983649eaf0ebd089fc852&insee=' . $insee);
        return $response->toArray();
    }

    public function getWeatherByInseeAndHour (string $insee){
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.meteo-concept.com/api/forecast/nextHours?token=7293fdc8b49b1840699c627230378b0b5b997958488983649eaf0ebd089fc852&insee=' . $insee);
        return $response->toArray();
    }

}
