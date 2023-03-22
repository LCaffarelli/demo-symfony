<?php

namespace App\Controller;

use App\Entity\Season;
use App\Form\SeasonType;
use App\Repository\SeasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/season/', name: 'season_')]
class SeasonController extends AbstractController
{
    #[Route('create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $season = new Season();
        $seasonForm = $this->createForm(SeasonType::class, $season);

        //hydrate l'instance de Season avec les données de la request
        $seasonForm->handleRequest($request);

        if ($seasonForm->isSubmitted() && $seasonForm->isValid()) {
            $season->setDateCreated(new \DateTime());
            $season->setDateModified(new \DateTime());

            $entityManager->persist($season);
            $entityManager->flush();

            $this->addFlash('success', 'Saison ajoutée !');
            return $this->redirectToRoute('serie_list');
        }

        return $this->render('season/create.html.twig', [
            'seasonForm' => $seasonForm,
        ]);
    }

    #[Route ('dissociate', name: 'dissociate')]
    public function dissociateSeasonWithSerie(SeasonRepository $seasonRepository)
    {
        $season = $seasonRepository->find(10);
        $season->setSerie(null);
        $series = [];
        return $this->render('serie/list.html.twig', ['series' => $series]);
    }
}
