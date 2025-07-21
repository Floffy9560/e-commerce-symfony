<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavigationController extends AbstractController
{
      #[Route('/', name: 'app_index')]
      public function index(): Response
      {
            return $this->render('index/index.html.twig');
      }

      // #[Route('/glass', name: 'app_glass')]
      // public function produits(): Response
      // {
      //       return $this->render('glass/index.html.twig');
      // }

      #[Route('/contacts', name: 'app_contacts')]
      public function contacts(): Response
      {
            return $this->render('contacts/index.html.twig');
      }

      #[Route('/panier', name: 'app_panier')]
      public function panier(): Response
      {
            return $this->render('cart/index.html.twig');
      }

      #[Route('/connexion', name: 'app_connexion')]
      public function connexion(): Response
      {
            return $this->render('login/index.html.twig');
      }
}
