<?php

namespace App\Controller;

use App\Entity\ContactDetails;
use App\Form\ContactDetailsType;
use App\Repository\ContactDetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact/details")
 */
class ContactDetailsController extends AbstractController
{
    /**
     * @Route("/", name="contact_details_index", methods={"GET"})
     */
    public function index(ContactDetailsRepository $contactDetailsRepository): Response
    {
        return $this->render('contact_details/index.html.twig', [
            'constance' => new Constance(),
            'contact_details' => $contactDetailsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contact_details_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $contactDetail = new ContactDetails();
        $form = $this->createForm(ContactDetailsType::class, $contactDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contactDetail);
            $entityManager->flush();

            return $this->redirectToRoute('contact_details_index');
        }

        return $this->render('contact_details/new.html.twig', [
            'constance' => new Constance(),
            'contact_detail' => $contactDetail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_details_show", methods={"GET"})
     */
    public function show(ContactDetails $contactDetail): Response
    {
        return $this->render('contact_details/show.html.twig', [
            'constance' => new Constance(),
            'contact_detail' => $contactDetail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contact_details_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ContactDetails $contactDetail): Response
    {
        $form = $this->createForm(ContactDetailsType::class, $contactDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_details_index');
        }

        return $this->render('contact_details/edit.html.twig', [
            'constance' => new Constance(),
            'contact_detail' => $contactDetail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_details_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ContactDetails $contactDetail): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contactDetail->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contactDetail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_details_index');
    }
}
