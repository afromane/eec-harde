<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupeController extends AbstractController
{
    /**
     * @Route("/groupe", name="app_groupe")
     */
    public function index(): Response
    {
        return $this->render('groupe/index.html.twig', [
            'controller_name' => 'GroupeController',
        ]);
    }

    /**
     * @Route("space/menu/new", name="app_menu_new",methods={"POST","GET"})
     */
    public function create(Request $request, EntityManagerInterface $em, MenuRepository $menuRepository): Response
    {

        $menu = new Menu();
        if ($_POST) {

            $menu->setLabel($request->request->get('label'));

            // $historique = new Historique();
            $session = $request->getSession();
            // $historique->setAction('insertion')
            //     ->setCreatedAt(new DateTimeImmutable())
            //     ->setEntite('type vente')
            //     ->setMembre($membreRepository->find($session->get('membreId')))
            //     ->setItem1((array)$types);

            // $em->persist($historique);

            $em->persist($menu);
            $em->flush();
            $this->addFlash('success', 'Element ajouter.');
            return $this->redirectToRoute('app_menu');
        }
        return $this->render(
            'menu/form.html.twig',
            array(
                'menu' => $menu,
                'action' => "Enregistrer",
                'label' => "Nouveau"
            )
        );
    }
}
