<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactsController extends AbstractController
{
    #[Route('/contacts', methods: ["GET"])]
    public function index(): Response
    {
        return $this->render('Contacts/contactsPage.html.twig', [
            'controller_name' => 'ContactsController',
        ]);
    }
}
