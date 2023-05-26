<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeliveryTermsController extends AbstractController
{
    #[Route('/terms', methods: ["GET"])]
    public function index(): Response
    {
        return $this->render('Terms/deliveryTermsPage.html.twig', [
            'controller_name' => 'DeliveryTermsController',
        ]);
    }
}
