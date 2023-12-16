<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeriesController extends AbstractController
{
    #[Route('/series', name: 'app_series')]
    public function seriesList(): Response
    {
        $seriesList = [
            'The Walking Dead',
            'Game of Thrones',
            'Breaking Bad',
            'The Big Bang Theory',
            'Stranger Things',
            'Vikings',
            'The Flash',
        ];

        return $this->render('series/index.html.twig', [
            'seriesList' => $seriesList,
        ]);
    }

    #[Route('/series/add', name: 'app_series_add', methods: ['GET', 'POST'])]
    public function seriesForm(): Response
    {
        return $this->render('series/form.html.twig');
    }
}
