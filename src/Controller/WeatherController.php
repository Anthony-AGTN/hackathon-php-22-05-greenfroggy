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
        if (($_SERVER['REQUEST_METHOD']) === 'POST') {
            $errors = [];
            $city = trim($_POST['city']);
            if (empty($city)) {
                $errors = 'error';
            }
            if (strlen($city) > 80) {
                $errors = 'error';
            }
            if (empty($errors)) {
                $weatherManager = new WeatherManager();
                $location = $weatherManager->getLocationByName($city);
                $insee = $location['cities'][0]['insee'];
                $weathers = $weatherManager->getWeatherByInsee($insee);

                $weather = $weathers['forecast'][0]['weather'];
                $weatherService = new WeatherService();
                $weatherPic = $weatherService->convertWeatherinPicture($weather);

                return $this->twig->render('Home/index.html.twig', [
                    'location' => $location,
                    'weathers' => $weathers,
                    'weatherPic' => $weatherPic
                ]);
            }
        }

        $weatherManager = new WeatherManager();
        $location = $weatherManager->getLocationByName('lyon');
        $insee = $location['cities'][0]['insee'];

        $weathers = $weatherManager->getWeatherByInsee($insee);

        $weather = $weathers['forecast'][0]['weather'];
        $weatherService = new WeatherService();
        $weatherPic = $weatherService->convertWeatherinPicture($weather);

        $tempMin = $weathers['forecast'][0]['tmin'];
        $tempMax = $weathers['forecast'][0]['tmax'];
        $optimist = $weatherService->optimistTemp($tempMin, $tempMax);
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

    public function future(): string
    {
        if (($_SERVER['REQUEST_METHOD']) === 'POST') {
            $errors = [];
            $city = trim($_POST['city']);
            if (empty($city)) {
                $errors = 'error';
            }
            if (strlen($city) > 80) {
                $errors = 'error';
            }
            if (empty($errors)) {
                $weatherManager = new WeatherManager();
                $location = $weatherManager->getLocationByName($city);
                $insee = $location['cities'][0]['insee'];
                $weathers = $weatherManager->getWeatherByInsee($insee);

                $weather = $weathers['forecast'][0]['weather'];
                $weatherService = new WeatherService();
                $weatherPic = $weatherService->convertWeatherinPicture($weather);

                return $this->twig->render('Home/index.html.twig', [
                    'location' => $location,
                    'weathers' => $weathers,
                    'weatherPic' => $weatherPic
                ]);
            }
        }

        $weatherManager = new WeatherManager();
        $location = $weatherManager->getLocationByName('lyon');
        $insee = $location['cities'][0]['insee'];

        $weathers = $weatherManager->getWeatherByInsee($insee);

        $weather = $weathers['forecast'][0]['weather'];
        $weatherService = new WeatherService();
        $weatherPic = $weatherService->convertWeatherinPicture($weather);

        $tempMin = $weathers['forecast'][0]['tmin'];
        $tempMax = $weathers['forecast'][0]['tmax'];
        $optimist = $weatherService->optimistTemp($tempMin, $tempMax);
        $realist = $weatherService->realistTemp($tempMin, $tempMax);
        $pessimist = $weatherService->pessimistTemp($tempMin, $tempMax);

        return $this->twig->render('Future/index.html.twig', [
            'location' => $location,
            'weathers' => $weathers,
            'weatherPic' => $weatherPic,
            'optimist' => $optimist,
            'realist' => $realist,
            'pessimist' => $pessimist
        ]);
    }
}
