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
            'constance' => new Constance(),
            'controller_name' => 'HomeController',
            'coffeeShops' => $coffeeShops,
            'isLightNave ' => false
        ]);
    }

    /**
     * @Route("/theme-one", name="theme_one_home")
     */
    public function themeOneIndex(): Response
    {

        $sendCategories = array();
        $imageGallery = array();
        $sendCategories = array();
        $videoGallery = array();
        $products = array();
        $coffeeShop = new CoffeeShop();
        $coffeeShop->setName("TEST");
        return $this->render('theme_one/index2.html.twig', [
            'constance' => new Constance(),
            'controller_name' => 'HomeController',
            'shop' => $coffeeShop,
            'categories' => $sendCategories,
            'imageGallery' => $imageGallery,
            'videoGallery' => $videoGallery,
            'products' => $products,
            'isLightNave' => true
        ]);
    }

    /**
     * @Route("/theme-one-product", name="theme_one_home_product")
     */
    public function themeOneProduct(): Response
    {
        return $this->render('theme_one/products.html.twig', [
            'constance' => new Constance(),
            'controller_name' => 'HomeController',
        ]);
    }
}
