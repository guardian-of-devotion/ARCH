<?php

namespace App\Controller;

use App\Entity\MenuCart;
use App\Entity\MenuItems;
use App\Repository\MenuCartRepository;
use App\Repository\MenuItemsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    private SessionInterface $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->session->start();
        $this->session->set('flag', '1');
    }

    #[Route("/menu/", methods: ["GET"])]
    public function showMenuPage(MenuItemsRepository $itemsRepository): Response
    {
        $items = $itemsRepository->findAll();


        return $this->render('Menu/menuPage.html.twig', [
            'controller_name' => 'MenuController',
            'items' => $items
        ]);
    }

    #[Route(path: 'menu/cart/{id<\d+>', name: 'add_to_cart')]
    /**
     * @param MenuItems $menuItems
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function addToCart(MenuItems $menuItems, EntityManagerInterface $em): Response
    {
        $sessionId = $this->session->getId();



        $menuCart = (new MenuCart())
            ->setMenuItem($menuItems)
            ->setCount(1)
            ->setSessionId($sessionId);

        $em->persist($menuCart);
        $em->flush();

        return $this->redirectToRoute('menu', ['id' => $menuItems->getId()]);
//
//           ->setMenuItem($menuItems)
//           ->setCount(1)
//           ->setSessionId()
    }

    public function menuCart(MenuCartRepository $cartRepository): Response
    {
        $session = $this->session->getId();
        $cart = $cartRepository->findBy(['session' => $session]);
        dd($cart);
    }
}
