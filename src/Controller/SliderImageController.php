<?php

namespace App\Controller;

use App\Entity\SliderImage;
use App\Form\SliderImageType;
use App\Repository\SliderImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/slider/image")
 */
class SliderImageController extends AbstractController
{
    /**
     * @Route("/", name="slider_image_index", methods={"GET"})
     */
    public function index(SliderImageRepository $sliderImageRepository): Response
    {
        return $this->render('slider_image/index.html.twig', [
            'constance' => new Constance(),
            'slider_images' => $sliderImageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="slider_image_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sliderImage = new SliderImage();
        $form = $this->createForm(SliderImageType::class, $sliderImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sliderImage);
            $entityManager->flush();

            return $this->redirectToRoute('slider_image_index');
        }

        return $this->render('slider_image/new.html.twig', [
            'constance' => new Constance(),
            'slider_image' => $sliderImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="slider_image_show", methods={"GET"})
     */
    public function show(SliderImage $sliderImage): Response
    {
        return $this->render('slider_image/show.html.twig', [
            'constance' => new Constance(),
            'slider_image' => $sliderImage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="slider_image_edit", methods={"GET","POST"})
     * @param Request $request
     * @param SliderImage $sliderImage
     * @return Response
     */
    public function edit(Request $request, SliderImage $sliderImage): Response
    {
        $form = $this->createForm(SliderImageType::class, $sliderImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('slider_image_index');
        }

        return $this->render('slider_image/edit.html.twig', [
            'constance' => new Constance(),
            'slider_image' => $sliderImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="slider_image_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SliderImage $sliderImage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sliderImage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sliderImage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('slider_image_index');
    }
}
