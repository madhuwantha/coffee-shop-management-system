<?php

namespace App\Controller;

use App\Entity\ProfilePicture;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,FileUploader $fileUploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPER_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');


        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $profilePhoto = $form->get('file')->getData();
            if ($profilePhoto){
                $path = $fileUploader->upload($profilePhoto);
                $profilePicture = new ProfilePicture();
                $profilePicture->setPath($path);
                $user->addProfilePicture($profilePicture);
            }

            $isAdmin = $form->get('isAdmin')->getViewData();
            if ($isAdmin == 1){
                $user->setRoles(["ROLE_ADMIN"]);
            }else{
                $user->setRoles(["ROLE_USER"]);
            }

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
