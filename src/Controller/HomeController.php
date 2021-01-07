<?php

namespace App\Controller;

use App\Entity\CoffeeShop;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $coffeeShops = $entityManager->getRepository(CoffeeShop::class)->findAll();



        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'coffeeShops' => $coffeeShops
        ]);
    }

    /**
     * @Route("/theme-one", name="theme_one_home")
     */
    public function themeOneIndex(): Response
    {
        return $this->render('theme_one/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/theme-one-product", name="theme_one_home_product")
     */
    public function themeOneProduct(): Response
    {
        return $this->render('theme_one/products.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
