<?php

namespace App\Controller;

use App\Model\WeatherManager;
use App\Service\WeatherService;

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

        $weather = $weathers['forecast'][0]['weather'];
        $weatherService = new WeatherService();
        $weatherPic = $weatherService->convertWeatherinPicture($weather);

        $tempMin = $weathers['forecast'][0]['tmin'];
        $tempMax = $weathers['forecast'][0]['tmax'];
        $optimist = $weatherService->optimistTemp ($tempMin, $tempMax);
        $realist = $weatherService->realistTemp($tempMin, $tempMax);
        $pessimist = $weatherService->pessimistTemp($tempMin, $tempMax);

        return $this->twig->render('Home/index.html.twig', [
            'location' => $location,
            'weathers' => $weathers,
            'weatherPic' => $weatherPic,
            'optimist' => $optimist,
            'realist' => $realist,
            'pessimist' => $pessimist
        ]);
    }
}

