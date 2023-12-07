<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\TextUI\XmlConfiguration\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupeController extends AbstractController
{
    /**
     * @Route("/groupe", name="app_groupe")
     */
    public function index(GroupeRepository $groupeRepository): Response
    {
        return $this->render('groupe/index.html.twig', [
            'items' => $groupeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/groupe/new", name="app_groupe_new",methods={"POST","GET"})
     */
    public function create(Request $request, EntityManagerInterface $em, GroupeRepository $groupeRepository): Response
    {

        $groupe = new Groupe();
        if ($_POST) {

            $groupe->setLabel($request->request->get('label'));
            $em->persist($groupe);

            $em->flush();
            $this->addFlash('success', 'Element ajouter.');
            return $this->redirectToRoute('app_groupe');
        }
        return $this->render(
            'groupe/form.html.twig',
            array(
                'item' => $groupe,
                'action' => "Enregistrer",
                'label' => "Nouveau"
            )
        );
    }

    /**
     * @Route("/groupe/update/{id}", name="app_groupe_update",methods={"POST","GET"})
     */
    public function editer($id, Request $request, EntityManagerInterface $em, GroupeRepository $groupeRepository): Response
    {

        $split = explode('#', $id);
        $id = intval($split[1]);
        $groupe = new Groupe();
        $groupe = $groupeRepository->find($id);
        if ($_POST) {
            $groupe->setLabel($request->request->get('label'));


            $groupe->setLabel($request->request->get('label'));
            $em->flush();
            $this->addFlash('success', 'Element mis a jour.');
            return $this->redirectToRoute('app_groupe');
        }
        return $this->render(
            'groupe/form.html.twig',
            array(
                'item' => $groupe,
                'action' => "Mettre a jour",
                'label' => "Mettre a jour"
            )
        );
    }
}
