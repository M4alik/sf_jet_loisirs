<?php

namespace App\Controller;

use App\Entity\Creneau;
use App\Entity\Activity;
use App\Entity\Planning;
use App\Form\CreneauConfirmerType;
use App\Repository\CreneauRepository;
use App\Repository\ActivityRepository;
use App\Repository\PlanningRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ReserverController extends AbstractController
{
    #[Route('/choisir_activite', name: 'app_reserver_activity')]
    #[IsGranted('ROLE_USER')]
    public function index(ActivityRepository $activityRepository): Response
    {
        return $this->render('reserver/index.html.twig', [
            'activities' => $activityRepository->findAll(),
        ]);
    }

    #[Route('/activity/{activity}/choisir_planning', name: 'app_reserver_planning')]
    public function index_planning(Activity $activity, PlanningRepository $planningRepository): Response
    {
        return $this->render('reserver/index_planning.html.twig', [
            'plannings' => $planningRepository->findBy(['nom_activite' => $activity]),
        ]);
    }

    //todo prevoir un controller qui va afficher les creneaux reliés au planning choisi : url = planning/{planning}/choisir_creneau et le template affichera la liste des creneau avec l'action choisir
    
    #[Route('/planning/{planning}/choisir_creneau', name: 'app_reserver_creneau')]
    public function index_creneau(Planning $planning): Response
    {
        return $this->render('reserver/index_creneaux.html.twig', [
            'creneaus' => $planning->getCreneaux(),
            'planning' => $planning,
        ]);
    }
    
    //todo la derniere etape : afficher le formulaire où on peut choisir le nb_participant pour le creneau choisi à l'etape precedente
    #[Route('/creneau/{creneau}/reserver', name: 'app_creneau_confirmer', methods: ['GET', 'POST'])]
    public function confirmer(Request $request, Creneau $creneau, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CreneauConfirmerType::class, $creneau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $creneau->setStatus(true);
            $creneau->setAuthor($this->getUser());
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reserver/edit.html.twig', [
            'creneau' => $creneau,
            'form' => $form,
        ]);
    }

    #[Route('/mescreneaux', name: 'app_mes_creneaux')]
    public function index_mescreneaux(CreneauRepository $creneauRepository): Response
    {
        return $this->render('reserver/index_mescreneaux.html.twig', [
            'creneaus' => $creneauRepository->findBy(['author'=>$this->getUser()]),
        ]);
    }
}
