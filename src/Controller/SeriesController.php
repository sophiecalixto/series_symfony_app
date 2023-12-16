<?php

namespace App\Controller;

use App\Entity\Series;
use App\Repository\SeriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeriesController extends AbstractController
{

    public function __construct(private SeriesRepository $seriesRepository)
    {
    }

    #[Route('/series', name: 'app_series')]
    public function seriesList(): Response
    {
        $seriesList = $this->seriesRepository->findAll();

        return $this->render('series/index.html.twig', [
            'seriesList' => $seriesList,
        ]);
    }

    #[Route('/series/add', name: 'app_series_add', methods: ['GET'])]
    public function addSeriesForm(): Response
    {
        return $this->render('series/form.html.twig');
    }

    #[Route('/series/add', name: 'app_series_add_post', methods: ['POST'])]
    public function addSeries(Request $request) : Response
    {
        $series = new Series();
        $series->setName($request->request->get('name'));

        $this->seriesRepository->save($series);

        return $this->redirectToRoute('app_series');
    }
}
