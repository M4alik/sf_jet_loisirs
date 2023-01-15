<?php

namespace App\Controller;

use App\Entity\Creneau;
use App\Entity\Planning;
use App\Form\PlanningType;
use App\Repository\CreneauRepository;
use App\Repository\PlanningRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/planning")
 */

 #[IsGranted('ROLE_ADMIN')]
class PlanningController extends AbstractController
{
    /**
     * @Route("/", name="app_planning_index", methods={"GET"})
     */
    public function index(PlanningRepository $planningRepository): Response
    {
        return $this->render('planning/index.html.twig', [
            'plannings' => $planningRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_planning_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PlanningRepository $planningRepository, CreneauRepository $creneauRepository): Response
    {
        $planning = new Planning();
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planningRepository->add($planning, true);
            $nb_jours = $planning->getNbJours();
            $nb_creneau_par_jour = $planning->getDureeJournee()/$planning->getDureeCrenau();
            $dureeCreneau = $planning->getDureeCrenau();
            $dateDebut = $planning->getDateDebut();
            for($i=0 ;$i<$nb_jours;$i++){

                // on utilise "clone" (ou "__clone") pour ne pas modifier les variables d'origine (attention clone ne peut être utilisé que sur des objets)
                if($i == 0){
                    $dateDebutClone = clone $dateDebut;
                } else {
                    //à chaque tour de boucle, on ajoutera 1 journée à la journée précédente
                    // si on commence au 1er janvier, on enchainera au 2, 3, 4...janvier
                    $dateDebutClone = clone $dateDebut->add(new \DateInterval('P1D'));
                }
                for($j=0; $j<$nb_creneau_par_jour;$j++)
                {
                    $creneau = new Creneau();
                    $creneau->setStatus(false);
                    $creneau->setPlanning($planning);
                    if($j == 0){
                        $dateDebutCreneau = clone $dateDebutClone;
                    } else {
                        // à chaque tour de boucle, on ajoutera la durée du créneau pour passer au créneau suivant (on précise la durée du créneau en minutes à \DateInterval()
                        $dateDebutCreneau = $dateDebutCreneau->add(new \DateInterval('PT'.$dureeCreneau.'M'));
                    }
                    $creneau->setDateDebut(clone $dateDebutCreneau);
                    $dateDebutCreneauClone = clone $dateDebutCreneau;
                    // la date de fin est logiquement la date de début + la durée du créneau
                    $dateFinCreneau = $dateDebutCreneauClone->add(new \DateInterval(('PT'.$dureeCreneau.'M')));
                    $creneau->setDateFin($dateFinCreneau);
                    $creneau->setNbParticipant(0);
                    $creneauRepository->add($creneau, true);
                }
            }
            return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planning/new.html.twig', [
            'planning' => $planning,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_planning_show", methods={"GET"})
     */
    public function show(Planning $planning): Response
    {
        return $this->render('planning/show.html.twig', [
            'planning' => $planning,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_planning_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Planning $planning, PlanningRepository $planningRepository): Response
    {
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planningRepository->add($planning, true);

            return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planning/edit.html.twig', [
            'planning' => $planning,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_planning_delete", methods={"POST"})
     */
    public function delete(Request $request, Planning $planning, PlanningRepository $planningRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planning->getId(), $request->request->get('_token'))) {
            $planningRepository->remove($planning, true);
        }

        return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/change_status", name="app_planning_change_status", methods={"GET", "POST"})
     */
    public function change_status(Planning $planning, PlanningRepository $planningRepository): Response
    {
        $status = $planning->isStatus();
        $planning->setStatus(!$status);
        $planningRepository->add($planning, true);
        return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
    }


}
