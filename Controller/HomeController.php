<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route("/home/", methods: ["GET"], name: 'app_home')]
    public function showStartPage()
    {
        return $this->render('homePage/homePage.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
