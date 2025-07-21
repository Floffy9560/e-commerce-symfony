<?php

namespace App\Controller;

use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Glass;
use Symfony\Component\HttpFoundation\Request;



final class CartController extends AbstractController
{


    #[Route('/cart', name: 'cart_index')]
    public function index(CartRepository $cartRepository): Response
    {
        //vérifier si un utilisateur est connecté
        $user = $this->getUser();

        if (!$user) {
            // Soit rediriger vers la page de connexion
            return $this->redirectToRoute('app_login');
            // ou afficher un message d'erreur
        }

        $cart = $cartRepository->findBy(['usercart' => $user]);

        // Calcul du total global
        $total = 0;
        foreach ($cart as $entry) {
            $total += $entry->getItem()->getPrice() * $entry->getQuantity();
        }

        return $this->render('cart/index.html.twig', [
            'cart'  => $cart,
            'total' => $total,
        ]);
    }

    // ==== AJOUT AU PANIER ==== //
    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['GET'])]
    public function add(int $id, EntityManagerInterface $em, CartRepository $cartRepository): RedirectResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer le produit (Glass) via l'EntityManager ou un repository Glass (à adapter)
        $glass = $em->getRepository(Glass::class)->find($id);
        if (!$glass) {
            $this->addFlash('error', 'Produit introuvable.');
            return $this->redirectToRoute('app_glasses');
        }

        // On récupère l’Item associé
        $item = $glass->getItem();

        // Vérifier si déjà présent dans le panier
        $cartEntry = $cartRepository->findOneBy(['usercart' => $user, 'item' => $item]);

        if ($cartEntry) {
            // Incrémenter la quantité
            $cartEntry->setQuantity($cartEntry->getQuantity() + 1);
        } else {
            // Créer une nouvelle entrée panier
            $cartEntry = new \App\Entity\Cart();
            $cartEntry->setUsercart($user);
            $cartEntry->setItem($item);
            $cartEntry->setQuantity(1);
            $em->persist($cartEntry);
        }

        $em->flush();

        $this->addFlash('success', 'Produit ajouté au panier.');

        return $this->redirectToRoute('app_glasses');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['GET'])]
    public function remove(int $id, CartRepository $cartRepository, EntityManagerInterface $em): RedirectResponse
    {
        //vérifier si un utilisateur est connecté
        $user = $this->getUser();

        if (!$user) {
            // Soit rediriger vers la page de connexion
            return $this->redirectToRoute('app_login');
            // ou afficher un message d'erreur
        }

        // Trouver l'entrée Cart correspondant à l'id ET à l'utilisateur connecté
        $cartEntry = $cartRepository->findOneBy(['id' => $id, 'usercart' => $user]);

        if ($cartEntry) {
            $em->remove($cartEntry);
            $em->flush();
            $this->addFlash('success', 'Produit retiré du panier.');
        } else {
            $this->addFlash('error', 'Produit non trouvé ou accès refusé.');
        }

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/update/{id}/{action}', name: 'cart_update', methods: ['GET'])]
    public function updateQuantity(int $id, string $action, CartRepository $cartRepository, EntityManagerInterface $em): RedirectResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $cartEntry = $cartRepository->findOneBy(['id' => $id, 'usercart' => $user]);
        if (!$cartEntry) {
            $this->addFlash('error', 'Produit non trouvé.');
            return $this->redirectToRoute('cart_index');
        }

        if ($action === 'increase') {
            $cartEntry->setQuantity($cartEntry->getQuantity() + 1);
        } elseif ($action === 'decrease') {
            $newQty = $cartEntry->getQuantity() - 1;
            if ($newQty > 0) {
                $cartEntry->setQuantity($newQty);
            } else {
                $em->remove($cartEntry); // si quantité = 0, on supprime
            }
        }

        $em->flush();
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/clear', name: 'cart_clear', methods: ['GET'])]
    public function clear(CartRepository $cartRepository, EntityManagerInterface $em): RedirectResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $cart = $cartRepository->findBy(['usercart' => $user]);
        foreach ($cart as $entry) {
            $em->remove($entry);
        }
        $em->flush();

        $this->addFlash('success', 'Votre panier a été vidé.');
        return $this->redirectToRoute('cart_index');
    }
}
