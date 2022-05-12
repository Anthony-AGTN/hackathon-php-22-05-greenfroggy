<?php

namespace App\Controller;

use App\Model\WeatherManager;

class WeatherController extends AbstractController
{
    /**
     * List location
     */
    public function index(): string
    {
        $weatherManager = new WeatherManager();
        $location = $weatherManager->getLocationByName('Lyon');

        $insee = $location['cities'][0]['insee'];

        $weathers = $weatherManager->getWeatherByInsee($insee);

        return $this->twig->render('Item/index.html.twig', [
            'location' => $location,
            'weathers' => $weathers
        ]);
    }
}

