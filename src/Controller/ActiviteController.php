<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Media;
use App\Service\FileUploader;
use App\Repository\ActiviteRepository;
use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TypeActiviteRepository;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActiviteController extends AbstractController
{
    /**
     * @Route("/activite", name="app_activite")
     */
    public function index(ActiviteRepository $activiteRepository): Response
    {
        return $this->render('activite/index.html.twig', [
            'items' => $activiteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/activite/new", name="app_activite_new",methods={"POST","GET"})
     */
    public function create(
        Request $request,
        EntityManagerInterface $em,
        ActiviteRepository $activiteRepository,
        TypeActiviteRepository $typeActiviteRepository,
        FileUploader $fileUploader
    ): Response {

        $activity = new Activite();
        $media  = new Media();
        if ($_POST) {

            /** @var UploadedFile $uploadFile */
            $file = $request->files->get('path');

            $sub = 'activities/';
            $filename = $sub . $fileUploader->upload($file, $sub);
            $type = $typeActiviteRepository->find((int)$request->request->get('activite'));

            $activity->setTitle($request->request->get('title'))
                ->setDescription($request->request->get('description'))
                ->setType($type)
                ->setPath($filename)
                ->setCreatedAt(new DateTimeImmutable());
            // $media->setPath($filename)
            //     ->setActivite($activity);
            // $em->persist($media);
             $em->persist($activity);
            $em->flush();
            $this->addFlash('success', 'Element ajouter.');
            return $this->redirectToRoute('app_activite');
        }
        return $this->render(
            'activite/form.html.twig',
            array(
                'item' => $activity,
                'action' => "Enregistrer",
                'label' => "Nouveau",
                'imgShow' => true,
                'types' => $typeActiviteRepository->findAll()
            )
        );
    }

    /**
     * @Route("/activite/update/{id}", name="app_activite_update",methods={"POST","GET"})
     */
    public function editer($id, Request $request, EntityManagerInterface $em, ActiviteRepository $activiteRepository,TypeActiviteRepository $typeActiviteRepository): Response
    {

        $split = explode('#', $id);
        $id = intval($split[1]);
        $activity = new Activite();
        $activity = $activiteRepository->find($id);

        if ($_POST) {

            $type = $typeActiviteRepository->find((int)$request->request->get('activite'));

            $activity->setTitle($request->request->get('title'))
                ->setDescription($request->request->get('description'))
                ->setType($type);
             $em->flush();
            $this->addFlash('success', 'Element mis a jour.');
            return $this->redirectToRoute('app_activite');
        }
        return $this->render(
            'activite/form.html.twig',
            array(
                'item' => $activity,
                'action' => "Mettre a jour",
                'label' => "Mettre a jour",
                'imgShow' => false,
                'types' => $typeActiviteRepository->findAll()

            )
        );
    }
}
