<?php

namespace App\Controller;

use App\Repository\GlassRepository;
use App\Repository\CategoryRepository;
use App\Repository\GenderRepository;
use App\Repository\BrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GlassController extends AbstractController
{
    #[Route('/glasses', name: 'app_glasses')]
    public function index(
        GlassRepository $glassRepo,
        CategoryRepository $categoryRepo,
        GenderRepository $genderRepo,
        BrandRepository $brandRepo
    ): Response {
        // Récupération des données
        $glasses    = $glassRepo->findAll();       // Toutes les lunettes
        $categories = $categoryRepo->findAll();    // Catégories pour le filtre
        $genders    = $genderRepo->findAll();      // Genres pour le filtre
        $brands     = $brandRepo->findAll();       // Marques pour le filtre

        return $this->render('glasses/index.html.twig', [
            'glasses'    => $glasses,
            'categories' => $categories,
            'genders'    => $genders,
            'brands'     => $brands,
        ]);
    }
}
