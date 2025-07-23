<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserInfo;
use App\Form\UserType;
use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route('', name: 'app_user', methods: ['GET'])]
    public function index(): Response
    {
        // Récupérer l'utilisateur connecté
        /** @var User|null $user */
        $user = $this->getUser();

        if (!$user) {
            // Si personne n'est connecté, on redirige vers login
            return $this->redirectToRoute('app_login');
        }
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
    ): Response {
        $user = new User();
        $userInfo = new UserInfo();
        $user->setUserInfo($userInfo);

        // Rôle par défaut
        $user->setRoles(['ROLE_USER']);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        dump($form->get('plainPassword')->getData());

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupérer le plainPassword du formulaire
            $user->setPassword(
                $passwordHasher->hashPassword($user, $form->get('plainPassword')->getData())
            );

            //Enregistrement en bdd
            $entityManager->persist($userInfo);
            $entityManager->persist($user);
            $entityManager->flush();

            // redirection, message, etc.
            $this->addFlash('success', 'Enregistrement réussi.');
            return $this->redirectToRoute('app_user');
        }


        return $this->render('user/new.html.twig', [
            'form' => $form,
        ]);
    }
}
