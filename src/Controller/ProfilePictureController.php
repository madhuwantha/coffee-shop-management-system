<?php

namespace App\Controller;

use App\Entity\ProfilePicture;
use App\Form\ProfilePictureType;
use App\Repository\ProfilePictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile/picture")
 */
class ProfilePictureController extends AbstractController
{
    /**
     * @Route("/", name="profile_picture_index", methods={"GET"})
     */
    public function index(ProfilePictureRepository $profilePictureRepository): Response
    {
        return $this->render('profile_picture/index.html.twig', [
            'profile_pictures' => $profilePictureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="profile_picture_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $profilePicture = new ProfilePicture();
        $form = $this->createForm(ProfilePictureType::class, $profilePicture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profilePicture);
            $entityManager->flush();

            return $this->redirectToRoute('profile_picture_index');
        }

        return $this->render('profile_picture/new.html.twig', [
            'profile_picture' => $profilePicture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="profile_picture_show", methods={"GET"})
     */
    public function show(ProfilePicture $profilePicture): Response
    {
        return $this->render('profile_picture/show.html.twig', [
            'profile_picture' => $profilePicture,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="profile_picture_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProfilePicture $profilePicture): Response
    {
        $form = $this->createForm(ProfilePictureType::class, $profilePicture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_picture_index');
        }

        return $this->render('profile_picture/edit.html.twig', [
            'profile_picture' => $profilePicture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="profile_picture_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProfilePicture $profilePicture): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profilePicture->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($profilePicture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profile_picture_index');
    }
}
