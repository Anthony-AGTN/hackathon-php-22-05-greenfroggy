<?php

namespace App\Model;
use Symfony\Component\HttpClient\HttpClient;

class WeatherManager extends AbstractManager
{

    private string $apiTokenMeteoConcept = API_TOKEN_METEO_CONCEPT;

    public function getLocationByName(string $name){
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://api.meteo-concept.com/api/location/cities?token=' . $this->apiTokenMeteoConcept . '&search=' . $name);
        return $response->toArray();
    }

    public function getWeatherByInsee (string $insee){
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.meteo-concept.com/api/forecast/daily?token=' . $this->apiTokenMeteoConcept . '&insee=' . $insee);
        return $response->toArray();
    }

    public function getWeatherByInseeAndHour (string $insee){
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.meteo-concept.com/api/forecast/nextHours?token=' . $this->apiTokenMeteoConcept . '&insee=' . $insee);
        return $response->toArray();
    }

}
