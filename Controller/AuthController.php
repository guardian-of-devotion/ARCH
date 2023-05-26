<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/auth/', methods: ["GET"])]
    public function index(): Response
    {
        return $this->render('Authorization/AuthPage.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }
}
