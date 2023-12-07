<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeActiviteController extends AbstractController
{
    /**
     * @Route("/type/activite", name="app_type_activite")
     */
    public function index(): Response
    {
        return $this->render('type_activite/index.html.twig', [
            'controller_name' => 'TypeActiviteController',
        ]);
    }
}
