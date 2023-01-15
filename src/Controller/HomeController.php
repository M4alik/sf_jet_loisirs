<?php

namespace App\Controller;

use App\Entity\Creneau;
use App\Entity\Planning;
use App\Repository\CreneauRepository;
use App\Repository\ActivityRepository;
use App\Repository\PlanningRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ActivityRepository $activityRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'activities' => $activityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/planning/{planning}/reserver", name="app_voir_creneaux")
     */
    public function voir_creneaux(Planning $planning): Response
    {

        return $this->render('home/index_creneau.html.twig', [
            'planning' => $planning,
        ]);
    }

    /**
     * @Route("/creneau/{creneau}/reserver", name="app_reserver_creneau")
     */
    public function reserver_creneau(Creneau $creneau, CreneauRepository $creneauRepository): Response
    {
        $creneau->setAuthor($this->getUser());
        $creneauRepository->add($creneau, true);

        return $this->redirectToRoute('app_home');
    }


}
