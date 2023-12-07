<?php

namespace App\Controller;

use App\Entity\TypeActivite;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TypeActiviteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypeActiviteController extends AbstractController
{
    /**
     * @Route("/type/activite", name="app_type_activite")
     */
    public function index(TypeActiviteRepository $typeActiviteRepository): Response
    {
        return $this->render('type_activite/index.html.twig', [
            'items' => $typeActiviteRepository->findAll(),
        ]);
    }

     /**
     * @Route("/typeactivite/new", name="app_type_activite_new",methods={"POST","GET"})
     */
    public function create(Request $request, EntityManagerInterface $em, TypeActiviteRepository $typeActiviteRepository): Response
    {

        $activity = new TypeActivite();
        if ($_POST) {

            $activity->setLabel($request->request->get('label'))
                     ->setDescription($request->request->get('description'));
            $em->persist($activity);

            $em->flush();
            $this->addFlash('success', 'Element ajouter.');
            return $this->redirectToRoute('app_type_activite');
        }
        return $this->render(
            'type_activite/form.html.twig',
            array(
                'item' => $activity,
                'action' => "Enregistrer",
                'label' => "Nouvelle"
            )
        );
    }

    /**
     * @Route("/typeactivite/update/{id}", name="app_type_activite_update",methods={"POST","GET"})
     */
    public function editer($id, Request $request, EntityManagerInterface $em, TypeActiviteRepository $typeActiviteRepository): Response
    {

        $split = explode('#', $id);
        $id = intval($split[1]);
        $activity = new TypeActivite();
        $activity = $typeActiviteRepository->find($id);

        if ($_POST) {
            $activity->setLabel($request->request->get('label'))
                    ->setDescription($request->request->get('description'));
            $em->flush();
            $this->addFlash('success', 'Element mis a jour.');
            return $this->redirectToRoute('app_type_activite');
        }
        return $this->render(
            'type_activite/form.html.twig',
            array(
                'item' => $activity,
                'action' => "Mettre a jour",
                'label' => "Mettre a jour"
            )
        );
    }
}
