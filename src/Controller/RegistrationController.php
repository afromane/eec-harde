<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/account", name="app_account")
     */
    public function index(Request $request, UserRepository $userRepository): Response
    {
        return $this->render('registration/index.html.twig', [
            'items' => $userRepository->findAll(),

        ]);
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $pass = $this->genreate_password(10, 1);

        if ($_POST) {

            // encode the plain password
            $user->setUsername($request->request->get('username'))
                ->setStatus('actif')
                ->setCreatedAt(new DateTimeImmutable())
                // ->setEmail($request->request->get('email'))
                // ->setNomPrenom($request->request->get('name'))
                // ->setPlain($pass)
                ->setRoles(array($request->request->get('role')));
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $pass
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_account');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'pass' => $pass
        ]);
    }

   

    public function genreate_password($nbreCarac, $nbreBloc)
    {
        $pass = "";
        $chaine_alpha_num = "azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN123456789_#$";
        for ($i = 0; $i < $nbreBloc; $i++) {
            for ($j = 0; $j < $nbreCarac; $j++) {
                $pass .= $chaine_alpha_num[rand() % strlen($chaine_alpha_num)];
            }
            ($i == $nbreBloc - 1) ? $pass .= "" : $pass = "-";
        }
        return $pass;
    }
}
