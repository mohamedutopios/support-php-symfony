<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/formation')]
final class FomationController extends AbstractController
{

    #[Route('/', name: 'formation_index', methods: ['GET'])]
    public function index(FormationRepository $formationRepository): Response
    {
        $formations = $formationRepository->findAll();
       # dump($formations);
        return $this->render('fomation/_list.html.twig', [
            'formations' => $formations,
        ]);
    }

    #[Route('/frame', name: 'formation_list_frame', methods: ['GET', 'POST'])]
    public function liste(FormationRepository $formationRepository): Response
    {

        return $this->render('fomation/_list.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }


    #[Route('/{id}', name: 'app_formation_details', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $formation = $entityManager->getRepository(Formation::class)->find($id);

        if (!$formation) {
            throw $this->createNotFoundException('Formation not found');
        }

        return $this->render('fomation/_details.html.twig', [
            'formation' => $formation,
        ]);
    }


}
