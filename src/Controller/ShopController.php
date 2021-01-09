<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\CoffeeShop;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop/{shop_id}", name="shop")
     * @param $shop_id
     * @return Response
     */
    public function index($shop_id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $coffeeShop = $em->getRepository(CoffeeShop::class)->find($shop_id);

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
