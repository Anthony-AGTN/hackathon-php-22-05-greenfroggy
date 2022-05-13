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
        $location = $weatherManager->getLocationByName('Annecy');
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $city = trim($_POST['city']);
            $weatherService = new WeatherService();
            $errors = $weatherService->checkData($city);

            if (empty($errors)) {
                $weatherManager = new WeatherManager();

                $location = $weatherManager->getLocationByName($city);
                $insee = $location['cities'][0]['insee'];
                $weathers = $weatherManager->getWeatherByInsee($insee);
                $_SESSION['insee'] = $insee;

                $weather = $weathers['forecast'][0]['weather'];
                $weatherService = new WeatherService();
                $weatherPic = $weatherService->convertXtremWeatherinPicture($weather);

                $weatherByHour = $weatherManager->getWeatherByInseeAndHour($insee);
                $actualTemperature = $weatherByHour['forecast'][0]['temp2m'];

                $tempMin = $weathers['forecast'][0]['tmin'];
                $tempMax = $weathers['forecast'][0]['tmax'];

                $optimist = $weatherService->optimistTemp($tempMin, $tempMax, $actualTemperature);
                $realist = $weatherService->realistTemp($tempMin, $tempMax, $actualTemperature);
                $pessimist = $weatherService->pessimistTemp($tempMin, $tempMax, $actualTemperature);

                if (($_SERVER['REQUEST_METHOD'] === 'GET') && !empty($_GET)) {
                    if ($_GET["y"] === "50") {
                        $optimist = $weatherService->optimistTemp($tempMin, $tempMax, $actualTemperature);
                        $realist = $weatherService->realistTemp($tempMin, $tempMax, $actualTemperature);
                        $pessimist = $weatherService->pessimistTemp($tempMin, $tempMax, $actualTemperature);
                    }

                    if ($_GET["y"] === "100") {
                        $optimist = $weatherService->optimistTemp100($tempMin, $tempMax, $actualTemperature);
                        $realist = $weatherService->realistTemp100($tempMin, $tempMax, $actualTemperature);
                        $pessimist = $weatherService->pessimistTemp100($tempMin, $tempMax, $actualTemperature);
                    }

                    if ($_GET["y"] === "150") {
                        $optimist = [99.9, 99.9, 99.9, 99.9];
                        $realist = [99.9, 99.9, 99.9, 99.9];
                        $pessimist = [99.9, 99.9, 99.9, 99.9];
                        $weatherPic = '/assets/images/Icons/ultra-x-treme/flame.png';
                    }
                }

                $tempOptFelt = $weatherService->xtremTemperatureFelt($weather, round($optimist[2]));
                $tempRealFelt = $weatherService->xtremTemperatureFelt($weather, round($realist[2]));
                $tempPessFelt = $weatherService->xtremTemperatureFelt($weather, round($pessimist[2]));

                return $this->twig->render('Future/index.html.twig', [
                    'location' => $location,
                    'weathers' => $weathers,
                    'weatherPic' => $weatherPic,
                    'optimist' => $optimist,
                    'realist' => $realist,
                    'pessimist' => $pessimist,
                    'tempOptFelt' => $tempOptFelt,
                    'tempRealFelt' => $tempRealFelt,
                    'tempPessFelt' => $tempPessFelt
                ]);
            }
        }

        if (isset($_SESSION['insee'])) {
            $weatherManager = new WeatherManager();
            $weathers = $weatherManager->getWeatherByInsee($_SESSION['insee']);
            $weather = $weathers['forecast'][0]['weather'];
            $weatherService = new WeatherService();
            $weatherPic = $weatherService->convertXtremWeatherinPicture($weather);

            $weatherByHour = $weatherManager->getWeatherByInseeAndHour($_SESSION['insee']);
            $actualTemperature = $weatherByHour['forecast'][0]['temp2m'];

            $tempMin = $weathers['forecast'][0]['tmin'];
            $tempMax = $weathers['forecast'][0]['tmax'];

            $optimist = $weatherService->optimistTemp($tempMin, $tempMax, $actualTemperature);
            $realist = $weatherService->realistTemp($tempMin, $tempMax, $actualTemperature);
            $pessimist = $weatherService->pessimistTemp($tempMin, $tempMax, $actualTemperature);

            if (($_SERVER['REQUEST_METHOD'] === 'GET') && !empty($_GET)) {
                if ($_GET["y"] === "50") {
                    $optimist = $weatherService->optimistTemp($tempMin, $tempMax, $actualTemperature);
                    $realist = $weatherService->realistTemp($tempMin, $tempMax, $actualTemperature);
                    $pessimist = $weatherService->pessimistTemp($tempMin, $tempMax, $actualTemperature);
                }

                if ($_GET["y"] === "100") {
                    $optimist = $weatherService->optimistTemp100($tempMin, $tempMax, $actualTemperature);
                    $realist = $weatherService->realistTemp100($tempMin, $tempMax, $actualTemperature);
                    $pessimist = $weatherService->pessimistTemp100($tempMin, $tempMax, $actualTemperature);
                }

                if ($_GET["y"] === "150") {
                    $optimist = [99.9, 99.9, 99.9, 99.9];
                    $realist = [99.9, 99.9, 99.9, 99.9];
                    $pessimist = [99.9, 99.9, 99.9, 99.9];
                    $weatherPic = '/assets/images/Icons/ultra-x-treme/flame.png';
                }
            }

            $tempOptFelt = $weatherService->xtremTemperatureFelt($weather, round($optimist[2]));
            $tempRealFelt = $weatherService->xtremTemperatureFelt($weather, round($realist[2]));
            $tempPessFelt = $weatherService->xtremTemperatureFelt($weather, round($pessimist[2]));

            return $this->twig->render('Future/index.html.twig', [
                'location' => $_SESSION['insee'],
                'weathers' => $weathers,
                'weatherPic' => $weatherPic,
                'optimist' => $optimist,
                'realist' => $realist,
                'pessimist' => $pessimist,
                'tempOptFelt' => $tempOptFelt,
                'tempRealFelt' => $tempRealFelt,
                'tempPessFelt' => $tempPessFelt

            ]);
        }

        $weatherManager = new WeatherManager();
        $location = $weatherManager->getLocationByName('Annecy');
        $insee = $location['cities'][0]['insee'];

        $weathers = $weatherManager->getWeatherByInsee($insee);

        $weather = $weathers['forecast'][0]['weather'];
        $weatherService = new WeatherService();
        $weatherPic = $weatherService->convertXtremWeatherinPicture($weather);

        $weatherByHour = $weatherManager->getWeatherByInseeAndHour($insee);
        $actualTemperature = $weatherByHour['forecast'][0]['temp2m'];

        $tempMin = $weathers['forecast'][0]['tmin'];
        $tempMax = $weathers['forecast'][0]['tmax'];

        $optimist = $weatherService->optimistTemp($tempMin, $tempMax, $actualTemperature);
        $realist = $weatherService->realistTemp($tempMin, $tempMax, $actualTemperature);
        $pessimist = $weatherService->pessimistTemp($tempMin, $tempMax, $actualTemperature);

        if (($_SERVER['REQUEST_METHOD'] === 'GET') && !empty($_GET)) {
            if ($_GET["y"] === "50") {
                $optimist = $weatherService->optimistTemp($tempMin, $tempMax, $actualTemperature);
                $realist = $weatherService->realistTemp($tempMin, $tempMax, $actualTemperature);
                $pessimist = $weatherService->pessimistTemp($tempMin, $tempMax, $actualTemperature);
            }

            if ($_GET["y"] === "100") {
                $optimist = $weatherService->optimistTemp100($tempMin, $tempMax, $actualTemperature);
                $realist = $weatherService->realistTemp100($tempMin, $tempMax, $actualTemperature);
                $pessimist = $weatherService->pessimistTemp100($tempMin, $tempMax, $actualTemperature);
            }

            if ($_GET["y"] === "150") {
                $optimist = [99.9, 99.9, 99.9, 99.9];
                $realist = [99.9, 99.9, 99.9, 99.9];
                $pessimist = [99.9, 99.9, 99.9, 99.9];
                $weatherPic = '/assets/images/Icons/ultra-x-treme/flame.png';
            }
        }

        $tempOptFelt = $weatherService->xtremTemperatureFelt($weather, round($optimist[2]));
        $tempRealFelt = $weatherService->xtremTemperatureFelt($weather, round($realist[2]));
        $tempPessFelt = $weatherService->xtremTemperatureFelt($weather, round($pessimist[2]));

        return $this->twig->render('Future/index.html.twig', [
            'location' => $location,
            'weathers' => $weathers,
            'weatherPic' => $weatherPic,
            'optimist' => $optimist,
            'realist' => $realist,
            'pessimist' => $pessimist,
            'tempOptFelt' => $tempOptFelt,
            'tempRealFelt' => $tempRealFelt,
            'tempPessFelt' => $tempPessFelt
        ]);
    }
}
