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

            $city = trim($_POST['city']);
            $weatherService = new WeatherService();
            $errors = $weatherService->checkData($city);

            if (empty($errors)) {
                $weatherManager = new WeatherManager();
                $location = $weatherManager->getLocationByName($city);
                $insee = $location['cities'][0]['insee'];
                $_SESSION['insee'] = $insee;
                $weathers = $weatherManager->getWeatherByInsee($insee);
            }
        }

        if (isset($_SESSION['insee'])) {
            $weatherManager = new WeatherManager();
            $weathers = $weatherManager->getWeatherByInsee($_SESSION['insee']);

            $weather = $weathers['forecast'][0]['weather'];
            $weatherService = new WeatherService();
            $weatherPic = $weatherService->convertWeatherinPicture($weather);

            $weatherByHour = $weatherManager->getWeatherByInseeAndHour($_SESSION['insee']);
            $actualTemperature = $weatherByHour['forecast'][0]['temp2m'];
            $tempFelt = $weatherService->temperatureFelt($weather, $actualTemperature);

            return $this->twig->render('Home/index.html.twig', [
                'location' => $_SESSION['insee'],
                'weathers' => $weathers,
                'weatherPic' => $weatherPic,
                'actualTemp' => $actualTemperature,
                'tempFelt' => $tempFelt
            ]);
        }

        $weatherManager = new WeatherManager();
        $location = $weatherManager->getLocationByName('lyon');
        $insee = $location['cities'][0]['insee'];
        $weathers = $weatherManager->getWeatherByInsee($insee);

        $weather = $weathers['forecast'][0]['weather'];
        $weatherService = new WeatherService();
        $weatherPic = $weatherService->convertWeatherinPicture($weather);

        $weatherByHour = $weatherManager->getWeatherByInseeAndHour($insee);
        $actualTemperature = $weatherByHour['forecast'][0]['temp2m'];
        $tempFelt = $weatherService->temperatureFelt($weather, $actualTemperature);

        return $this->twig->render('Home/index.html.twig', [
            'location' => $location,
            'weathers' => $weathers,
            'weatherPic' => $weatherPic,
            'actualTemp' => $actualTemperature,
            'tempFelt' => $tempFelt
        ]);
    }

    public function future(): string
    {
        if (($_SERVER['REQUEST_METHOD']) === 'POST') {
            $city = trim($_POST['city']);
            $weatherService = new WeatherService();
            $errors = $weatherService->checkData($city);

            if (empty($errors)) {
                $weatherManager = new WeatherManager();

                $location = $weatherManager->getLocationByName($city);
                $insee = $_SESSION['insee'];
                $weathers = $weatherManager->getWeatherByInsee($insee);
            }
        }

        if (isset($_SESSION['insee'])) {
            $weatherManager = new WeatherManager();
            $weathers = $weatherManager->getWeatherByInsee($_SESSION['insee']);
            $weather = $weathers['forecast'][0]['weather'];
            $weatherService = new WeatherService();
            $weatherPic = $weatherService->convertWeatherinPicture($weather);

            $tempMin = $weathers['forecast'][0]['tmin'];
            $tempMax = $weathers['forecast'][0]['tmax'];
            $optimist = $weatherService->optimistTemp($tempMin, $tempMax);
            $realist = $weatherService->realistTemp($tempMin, $tempMax);
            $pessimist = $weatherService->pessimistTemp($tempMin, $tempMax);

            return $this->twig->render('Future/index.html.twig', [
                'location' => $_SESSION['insee'],
                'weathers' => $weathers,
                'weatherPic' => $weatherPic,
                'optimist' => $optimist,
                'realist' => $realist,
                'pessimist' => $pessimist
            ]);
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
