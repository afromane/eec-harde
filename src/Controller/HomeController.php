<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
        ]);
    }

    /**
     * @Route("/enrolment", name="app_enrolment",methods={"POST","GET"})
     */
    public function enrolment(): Response
    {
        return $this->render('home/enrolment.html.twig', [
        ]);
    }
    /**
     * @Route("/activity", name="app_activity",methods={"POST","GET"})
     */
    public function activity(): Response
    {
        return $this->render('home/activity.html.twig', [
        ]);
    }
    
    /**
     * @Route("/about", name="app_about",methods={"POST","GET"})
     */
    public function about(): Response
    {
        return $this->render('home/about.html.twig', [
        ]);
    }
}
