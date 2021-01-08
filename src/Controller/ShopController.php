<?php

namespace App\Controller;

use App\Entity\CoffeeShop;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop/{shop_id}", name="shop")
     * @param CoffeeShop $coffeeShop
     * @return Response
     */
    public function index(CoffeeShop $coffeeShop): Response
    {

        $themeCode  = $coffeeShop->getTheme()->getCode();

        switch ($themeCode){
            case 'TWO':
                return $this->render('themes/two/index.html.twig', [
                    'controller_name' => 'ShopController',
                    'shop' => $coffeeShop
                ]);
            case 'ONE':
            default:
                return $this->render('themes/one/index.html.twig', [
                    'controller_name' => 'ShopController',
                    'shop' => $coffeeShop
                ]);
        }
    }
}
