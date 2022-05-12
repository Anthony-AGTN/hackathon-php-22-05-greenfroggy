<?php

namespace App\Model;
use Symfony\Component\HttpClient\HttpClient;

class WeatherManager extends AbstractManager
{
    public function getLocationBy(){
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://api.meteo-concept.com/api/location/cities?token=7293fdc8b49b1840699c627230378b0b5b997958488983649eaf0ebd089fc852&search=Rennes');
        return $response->toArray();
    }

}