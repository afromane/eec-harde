<?php

namespace App\Controller;

use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnrolementController extends AbstractController
{
    /**
     * @Route("/enrolement", name="app_enrolement")
     */
    public function index(): Response
    {
        return $this->render('enrolement/index.html.twig', [
            'controller_name' => 'EnrolementController',
        ]);
    }
    /**
     * @Route("/enrolement/attente", name="app_enrolement_en_attente")
     */
    public function enrolementAttente(MembreRepository $membreRepository): Response
    {
        return $this->render('enrolement/waiting.html.twig', [
            'membres' =>  $membreRepository->findBy(array(), array('id' => "DESC")),
        ]);
    }
    /**
     * @Route("/enrolement/confirmer", name="app_enrolement_confirmer")
     */
    public function enrolementConfirmer(): Response
    {
        dd("not available");
        return $this->render('enrolement/confirm.html.twig', [
            // 'membres' =>  $membreRepository->findBy(array(), array('id' => "DESC")),
        ]);
    }
}
