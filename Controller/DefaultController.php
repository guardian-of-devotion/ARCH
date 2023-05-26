<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Flex\Response;

class DefaultController extends AbstractController {

    #[Route('/', name: 'main_homepage')]
public function index(EntityManagerInterface $entityManager): Response {
        $productList = $entityManager -> getRepository(Product:: class)->findAll();

        return $this->render('homePage/homePage.html.twig', []);
    }
}