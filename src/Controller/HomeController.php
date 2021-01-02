<?php

namespace App\Controller;

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
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
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
}
