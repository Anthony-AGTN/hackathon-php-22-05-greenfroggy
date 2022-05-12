<?php

namespace App\Controller;

use App\Model\WeatherManager;

class WeatherController extends AbstractController
{
    /**
     * List items
     */
    public function index(): string
    {
        $weatherManager = new WeatherManager();
        $items = $itemManager->selectAll('title');

        return $this->twig->render('Item/index.html.twig', ['items' => $items]);
    }
}
