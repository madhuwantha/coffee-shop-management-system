<?php

namespace App\Controller;

use App\Entity\ItemImage;
use App\Form\ItemImageType;
use App\Repository\ItemImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/item/image")
 */
class ItemImageController extends AbstractController
{
    /**
     * @Route("/", name="item_image_index", methods={"GET"})
     */
    public function index(ItemImageRepository $itemImageRepository): Response
    {
        return $this->render('item_image/index.html.twig', [
            'item_images' => $itemImageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="item_image_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $itemImage = new ItemImage();
        $form = $this->createForm(ItemImageType::class, $itemImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($itemImage);
            $entityManager->flush();

            return $this->redirectToRoute('item_image_index');
        }

        return $this->render('item_image/new.html.twig', [
            'item_image' => $itemImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_image_show", methods={"GET"})
     */
    public function show(ItemImage $itemImage): Response
    {
        return $this->render('item_image/show.html.twig', [
            'item_image' => $itemImage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="item_image_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ItemImage $itemImage): Response
    {
        $form = $this->createForm(ItemImageType::class, $itemImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('item_image_index');
        }

        return $this->render('item_image/edit.html.twig', [
            'item_image' => $itemImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_image_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ItemImage $itemImage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemImage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($itemImage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_image_index');
    }
}
