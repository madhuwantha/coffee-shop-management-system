<?php

namespace App\Controller;

use App\Entity\OpenHour;
use App\Form\OpenHourType;
use App\Repository\OpenHourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/open/hour")
 */
class OpenHourController extends AbstractController
{
    /**
     * @Route("/", name="open_hour_index", methods={"GET"})
     */
    public function index(OpenHourRepository $openHourRepository): Response
    {
        return $this->render('open_hour/index.html.twig', [
            'constance' => new Constance(),
            'open_hours' => $openHourRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="open_hour_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $openHour = new OpenHour();
        $form = $this->createForm(OpenHourType::class, $openHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($openHour);
            $entityManager->flush();

            return $this->redirectToRoute('open_hour_index');
        }

        return $this->render('open_hour/new.html.twig', [
            'constance' => new Constance(),
            'open_hour' => $openHour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="open_hour_show", methods={"GET"})
     */
    public function show(OpenHour $openHour): Response
    {
        return $this->render('open_hour/show.html.twig', [
            'constance' => new Constance(),
            'open_hour' => $openHour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="open_hour_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OpenHour $openHour): Response
    {
        $form = $this->createForm(OpenHourType::class, $openHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('open_hour_index');
        }

        return $this->render('open_hour/edit.html.twig', [
            'constance' => new Constance(),
            'open_hour' => $openHour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="open_hour_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OpenHour $openHour): Response
    {
        if ($this->isCsrfTokenValid('delete'.$openHour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($openHour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('open_hour_index');
    }
}
