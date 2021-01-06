<?php

namespace App\Controller;

use App\Entity\Gallery;
use App\Form\GalleryType;
use App\Repository\GalleryRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gallery")
 */
class GalleryController extends AbstractController
{
    /**
     * @Route("/", name="gallery_index", methods={"GET"})
     */
    public function index(GalleryRepository $galleryRepository): Response
    {
        return $this->render('gallery/index.html.twig', [
            'galleries' => $galleryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="gallery_new", methods={"GET","POST"})
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $gallery = new Gallery();
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $galleryImages = $form->get('galleryImages')->getData();
            $galleryVideos = $form->get('galleryVideos')->getData();

            foreach ($galleryImages as $galleryImage){
                $f = $galleryImage->getFile();
                if ($f != null){
                    $path = $fileUploader->upload($f);
                    $galleryImage->setpath($path);
                }
            }

            foreach ($galleryVideos as $galleryVideo){
                $f = $galleryVideo->getFile();
                if ($f != null){
                    $path = $fileUploader->upload($f);
                    $galleryVideo->setpath($path);
                }
            }


            $gallery->setName($gallery->getCoffeeShop()->getName()."_GALLERY");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gallery);
            $entityManager->flush();

            return $this->redirectToRoute('gallery_index');
        }

        return $this->render('gallery/new.html.twig', [
            'gallery' => $gallery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gallery_show", methods={"GET"})
     */
    public function show(Gallery $gallery): Response
    {
        return $this->render('gallery/show.html.twig', [
            'gallery' => $gallery,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="gallery_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Gallery $gallery
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function edit(Request $request, Gallery $gallery, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $galleryImages = $form->get('galleryImages')->getData();
            $galleryVideos = $form->get('galleryVideos')->getData();

            foreach ($galleryImages as $galleryImage){
                $f = $galleryImage->getFile();
                if ($f != null){
                    $path = $fileUploader->upload($f);
                    $galleryImage->setpath($path);
                }
            }

            foreach ($galleryVideos as $galleryVideo){
                $f = $galleryVideo->getFile();
                if ($f != null){
                    $path = $fileUploader->upload($f);
                    $galleryVideo->setpath($path);
                }
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gallery_index');
        }

        return $this->render('gallery/edit.html.twig', [
            'gallery' => $gallery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gallery_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Gallery $gallery): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gallery->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gallery);
            $entityManager->flush();
        }

        return $this->redirectToRoute('gallery_index');
    }
}
