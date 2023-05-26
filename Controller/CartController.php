<?php

namespace App\Controller;

use App\Repository\MenuCartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/Cart', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('Cart/CartPage.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
