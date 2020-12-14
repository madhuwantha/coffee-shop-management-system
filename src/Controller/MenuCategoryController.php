<?php

namespace App\Controller;

use App\Entity\MenuCategory;
use App\Form\MenuCategoryType;
use App\Repository\MenuCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/menu/category")
 */
class MenuCategoryController extends AbstractController
{
    /**
     * @Route("/", name="menu_category_index", methods={"GET"})
     */
    public function index(MenuCategoryRepository $menuCategoryRepository): Response
    {
        return $this->render('menu_category/index.html.twig', [
            'menu_categories' => $menuCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="menu_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $menuCategory = new MenuCategory();
        $form = $this->createForm(MenuCategoryType::class, $menuCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($menuCategory);
            $entityManager->flush();

            return $this->redirectToRoute('menu_category_index');
        }

        return $this->render('menu_category/new.html.twig', [
            'menu_category' => $menuCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="menu_category_show", methods={"GET"})
     */
    public function show(MenuCategory $menuCategory): Response
    {
        return $this->render('menu_category/show.html.twig', [
            'menu_category' => $menuCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="menu_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MenuCategory $menuCategory): Response
    {
        $form = $this->createForm(MenuCategoryType::class, $menuCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('menu_category_index');
        }

        return $this->render('menu_category/edit.html.twig', [
            'menu_category' => $menuCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="menu_category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MenuCategory $menuCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$menuCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($menuCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('menu_category_index');
    }
}
