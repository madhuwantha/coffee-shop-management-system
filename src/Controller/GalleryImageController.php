<?php

namespace App\Controller;

use App\Entity\GalleryImage;
use App\Form\GalleryImageType;
use App\Repository\GalleryImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gallery/image")
 */
class GalleryImageController extends AbstractController
{
    /**
     * @Route("/", name="gallery_image_index", methods={"GET"})
     */
    public function index(GalleryImageRepository $galleryImageRepository): Response
    {
        return $this->render('gallery_image/index.html.twig', [
            'gallery_images' => $galleryImageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="gallery_image_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $galleryImage = new GalleryImage();
        $form = $this->createForm(GalleryImageType::class, $galleryImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($galleryImage);
            $entityManager->flush();

            return $this->redirectToRoute('gallery_image_index');
        }

        return $this->render('gallery_image/new.html.twig', [
            'gallery_image' => $galleryImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gallery_image_show", methods={"GET"})
     */
    public function show(GalleryImage $galleryImage): Response
    {
        return $this->render('gallery_image/show.html.twig', [
            'gallery_image' => $galleryImage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="gallery_image_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GalleryImage $galleryImage): Response
    {
        $form = $this->createForm(GalleryImageType::class, $galleryImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gallery_image_index');
        }

        return $this->render('gallery_image/edit.html.twig', [
            'gallery_image' => $galleryImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gallery_image_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GalleryImage $galleryImage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$galleryImage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($galleryImage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('gallery_image_index');
    }
}
