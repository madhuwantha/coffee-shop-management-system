<?php

namespace App\Controller;

use App\Entity\NextCategory;
use App\Form\NextCategoryType;
use App\Repository\NextCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/next/category")
 */
class NextCategoryController extends AbstractController
{
    /**
     * @Route("/", name="next_category_index", methods={"GET"})
     */
    public function index(NextCategoryRepository $nextCategoryRepository): Response
    {
        return $this->render('next_category/index.html.twig', [
            'next_categories' => $nextCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="next_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $nextCategory = new NextCategory();
        $form = $this->createForm(NextCategoryType::class, $nextCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nextCategory);
            $entityManager->flush();

            return $this->redirectToRoute('next_category_index');
        }

        return $this->render('next_category/new.html.twig', [
            'next_category' => $nextCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="next_category_show", methods={"GET"})
     */
    public function show(NextCategory $nextCategory): Response
    {
        return $this->render('next_category/show.html.twig', [
            'next_category' => $nextCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="next_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NextCategory $nextCategory): Response
    {
        $form = $this->createForm(NextCategoryType::class, $nextCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('next_category_index');
        }

        return $this->render('next_category/edit.html.twig', [
            'next_category' => $nextCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="next_category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, NextCategory $nextCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nextCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($nextCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('next_category_index');
    }
}
