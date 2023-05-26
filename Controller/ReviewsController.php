<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewsController extends AbstractController
{
    #[Route('/reviews', methods: ["GET"])]
    public function index(): Response
    {
        return $this->render('Reviews/reviewsPage.html.twig', [
            'controller_name' => 'ReviewsController',
        ]);
    }
}
