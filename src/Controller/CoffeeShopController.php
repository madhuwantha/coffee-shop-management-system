<?php

namespace App\Controller;

use App\Entity\CoffeeShop;
use App\Form\CoffeeShopType;
use App\Repository\CoffeeShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/coffee/shop")
 */
class CoffeeShopController extends AbstractController
{
    /**
     * @Route("/", name="coffee_shop_index", methods={"GET"})
     */
    public function index(CoffeeShopRepository $coffeeShopRepository): Response
    {
        return $this->render('coffee_shop/index.html.twig', [
            'coffee_shops' => $coffeeShopRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="coffee_shop_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $coffeeShop = new CoffeeShop();
        $form = $this->createForm(CoffeeShopType::class, $coffeeShop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($coffeeShop);
            $entityManager->flush();

            return $this->redirectToRoute('coffee_shop_index');
        }

        return $this->render('coffee_shop/new.html.twig', [
            'coffee_shop' => $coffeeShop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="coffee_shop_show", methods={"GET"})
     */
    public function show(CoffeeShop $coffeeShop): Response
    {
        return $this->render('coffee_shop/show.html.twig', [
            'coffee_shop' => $coffeeShop,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="coffee_shop_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CoffeeShop $coffeeShop): Response
    {
        $form = $this->createForm(CoffeeShopType::class, $coffeeShop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('coffee_shop_index');
        }

        return $this->render('coffee_shop/edit.html.twig', [
            'coffee_shop' => $coffeeShop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="coffee_shop_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CoffeeShop $coffeeShop): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coffeeShop->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($coffeeShop);
            $entityManager->flush();
        }

        return $this->redirectToRoute('coffee_shop_index');
    }
}
