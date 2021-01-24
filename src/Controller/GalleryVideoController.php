<?php

namespace App\Controller;

use App\Entity\GalleryVideo;
use App\Form\GalleryVideoType;
use App\Repository\GalleryVideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gallery/video")
 */
class GalleryVideoController extends AbstractController
{
    /**
     * @Route("/", name="gallery_video_index", methods={"GET"})
     */
    public function index(GalleryVideoRepository $galleryVideoRepository): Response
    {
        return $this->render('gallery_video/index.html.twig', [
            'constance' => new Constance(),
            'gallery_videos' => $galleryVideoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="gallery_video_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $galleryVideo = new GalleryVideo();
        $form = $this->createForm(GalleryVideoType::class, $galleryVideo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($galleryVideo);
            $entityManager->flush();

            return $this->redirectToRoute('gallery_video_index');
        }

        return $this->render('gallery_video/new.html.twig', [
            'constance' => new Constance(),
            'gallery_video' => $galleryVideo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gallery_video_show", methods={"GET"})
     */
    public function show(GalleryVideo $galleryVideo): Response
    {
        return $this->render('gallery_video/show.html.twig', [
            'constance' => new Constance(),
            'gallery_video' => $galleryVideo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="gallery_video_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GalleryVideo $galleryVideo): Response
    {
        $form = $this->createForm(GalleryVideoType::class, $galleryVideo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gallery_video_index');
        }

        return $this->render('gallery_video/edit.html.twig', [
            'constance' => new Constance(),
            'gallery_video' => $galleryVideo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gallery_video_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GalleryVideo $galleryVideo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$galleryVideo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($galleryVideo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('gallery_video_index');
    }
}
