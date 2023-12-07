<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Repository\ActiviteRepository;
use App\Repository\GroupeRepository;
use App\Repository\TypeActiviteRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(TypeActiviteRepository $typeActiviteRepository, ActiviteRepository $activiteRepository): Response
    {
        return $this->render('home/index.html.twig', [
            "types" => $typeActiviteRepository->findAll(),
            "activities" => $activiteRepository->findBy(array(), array('id' => "DESC"))
        ]);
    }

    /**
     * @Route("/enrolment", name="app_enrolment",methods={"POST","GET"})
     */
    public function enrolment(GroupeRepository $groupeRepository, Request $request, EntityManagerInterface $em): Response
    {

        if ($_POST) {

            $membres = new Membre();
            $membres->setContact($request->request->get('tel'))
                ->setNomPrenom($request->request->get('name'))
                ->setQuartier($request->request->get('quartier'))
                ->setEstCommuniant($request->request->get('communuant') == "oui" ? true : false)
                ->setGroupe($groupeRepository->find((int)$request->request->get('groupe')))
                ->setCreateAt(new DateTimeImmutable());
            $em->persist($membres);
            $em->flush();

            return new Response(json_encode("true"));
        }
        return $this->render('home/enrolment.html.twig', [
            "groupes" => $groupeRepository->findAll()
        ]);
    }
    /**
     * @Route("/activity", name="app_activity",methods={"POST","GET"})
     */
    public function activity(TypeActiviteRepository $typeActiviteRepository, ActiviteRepository $activiteRepository): Response
    {
        return $this->render('home/activity.html.twig', [
            "types" => $typeActiviteRepository->findAll(),
            "activities" => $activiteRepository->findBy(array(), array('id' => "DESC"), 10)
        ]);
    }

    /**
     * @Route("/about", name="app_about",methods={"POST","GET"})
     */
    public function about(): Response
    {
        return $this->render('home/about.html.twig', []);
    }
}
