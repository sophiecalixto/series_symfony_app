<?php

namespace App\Controller;

use App\Entity\Series;
use App\Form\SeriesType;
use App\Repository\SeriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeriesController extends AbstractController
{

    public function __construct(private SeriesRepository $seriesRepository)
    {
    }

    /**
     * @description List all series
     */
    #[Route('/series', name: 'app_series')]
    public function seriesList(): Response
    {
        $seriesList = $this->seriesRepository->findAll();

        return $this->render('series/index.html.twig', compact('seriesList'));
    }

    /**
     * @description Add a new series
     */
    #[Route('/series/add', name: 'app_series_add', methods: ['GET'])]
    public function addSeriesForm(): Response
    {
        $seriesForm = $this->createForm(SeriesType::class, new Series());
        return $this->render('series/form.html.twig', compact('seriesForm'));
    }

    #[Route('/series/add', name: 'app_series_add_post', methods: ['POST'])]
    public function addSeries(Request $request) : Response
    {
        $series = $this->createForm(SeriesType::class, new Series())->handleRequest($request)->getData();
        $this->addFlash('success', 'A serie ' . $series->getName() . ' foi adicionada com sucesso!');

        $this->seriesRepository->save($series);

        return $this->redirectToRoute('app_series');
    }

    /**
     * @description Delete series
     */
    #[Route('/series/delete/{id}', name: 'app_series_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteSeries(int $id) : Response
    {
        $this->seriesRepository->delete($id);
        $this->addFlash('success', 'A serie foi removida com sucesso!');

        return $this->redirectToRoute('app_series');
    }

    /**
     * @description Edit series
     */
    #[Route('/series/edit/{series}', name: 'app_series_edit', methods: ['GET'])]
    public function editSeriesForm(Series $series) : Response
    {
        $seriesForm = $this->createForm(SeriesType::class, $series, ['label' => 'Editar', 'method' => 'PATCH']);

        return $this->render('series/form.html.twig',
            compact('seriesForm', 'series')
        );
    }

    #[Route('/series/edit/{series}', name: 'app_series_edit_patch', methods: ['PATCH'])]
    public function editSeries(Request $request, Series $series) : Response
    {
        $seriesForm = $this->createForm(SeriesType::class, $series, ['label' => 'Editar', 'method' => 'PATCH']);
        $seriesForm->handleRequest($request);

        $this->seriesRepository->save($series);
        $this->addFlash('success', 'A serie ' . $series->getName() . ' foi editada com sucesso!');

        return $this->redirectToRoute('app_series');
    }
}
