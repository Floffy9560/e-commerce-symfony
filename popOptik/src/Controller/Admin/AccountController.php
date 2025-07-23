<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
final class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_admin_account')]
    public function index(): Response
    {
        return $this->render('admin/account/index.html.twig', [
            'controller_name' => 'Admin AccountController',
        ]);
    }
}
