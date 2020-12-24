<?php

namespace App\Controller;

use App\Entity\CoverPhoto;
use App\Form\CoverPhotoType;
use App\Repository\CoverPhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cover/photo")
 */
class CoverPhotoController extends AbstractController
{
    /**
     * @Route("/", name="cover_photo_index", methods={"GET"})
     */
    public function index(CoverPhotoRepository $coverPhotoRepository): Response
    {
        return $this->render('cover_photo/index.html.twig', [
            'cover_photos' => $coverPhotoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cover_photo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $coverPhoto = new CoverPhoto();
        $form = $this->createForm(CoverPhotoType::class, $coverPhoto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($coverPhoto);
            $entityManager->flush();

            return $this->redirectToRoute('cover_photo_index');
        }

        return $this->render('cover_photo/new.html.twig', [
            'cover_photo' => $coverPhoto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cover_photo_show", methods={"GET"})
     */
    public function show(CoverPhoto $coverPhoto): Response
    {
        return $this->render('cover_photo/show.html.twig', [
            'cover_photo' => $coverPhoto,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cover_photo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CoverPhoto $coverPhoto): Response
    {
        $form = $this->createForm(CoverPhotoType::class, $coverPhoto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cover_photo_index');
        }

        return $this->render('cover_photo/edit.html.twig', [
            'cover_photo' => $coverPhoto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cover_photo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CoverPhoto $coverPhoto): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coverPhoto->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($coverPhoto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cover_photo_index');
    }
}
