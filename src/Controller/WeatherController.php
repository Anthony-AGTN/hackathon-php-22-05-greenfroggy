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

                return $this->twig->render('Home/index.html.twig', [
                    'location' => $location,
                    'weathers' => $weathers
                ]);
            }
        }

        $weatherManager = new WeatherManager();
        $location = $weatherManager->getLocationByName('lyon');
        $insee = $location['cities'][0]['insee'];

        $weathers = $weatherManager->getWeatherByInsee($insee);

        return $this->twig->render('Home/index.html.twig', [
            'location' => $location,
            'weathers' => $weathers
        ]);
    }
}
