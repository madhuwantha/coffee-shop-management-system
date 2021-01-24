<?php

namespace App\Controller;

use App\Entity\ProfilePicture;
use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{


    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request, UserRepository $userRepository): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $this->security->getUser();
        $users = [];
        $k = false;
        if (in_array("ROLE_SUPPER_ADMIN", $user->getRoles())) {
            $query = $userRepository->findAll();
            $users = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                6
            );
            $k = true;
        } else {
            array_push($users, $user);
        }

        return $this->render('user/index.html.twig', [
            'constance' => new Constance(),
            'users' => $users,
            'k' => $k
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPER_ADMIN');


        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $profilePhoto = $form->get('file')->getData();
            $path = $fileUploader->upload($profilePhoto);

            $profilePicture = new ProfilePicture();
            $profilePicture->setPath($path);
            $user->addProfilePicture($profilePicture);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profilePicture);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'constance' => new Constance(),
            'user' => $user,
            'form' => $form->createView(),
            'edit' => false
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'constance' => new Constance(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function edit(Request $request, User $user, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $profilePhoto = $form->get('file')->getData();
            $entityManager = $this->getDoctrine()->getManager();
            if ($profilePhoto) {
                try {
                    $path = $fileUploader->upload($profilePhoto);

                    $profilePicture = $user->getProfilePictures()->get(0);
                    $profilePicture->setPath($path);

                    $entityManager->persist($profilePicture);
                } catch (FileException $e) {
                    $u = $this->getUser();

                    if (in_array("ROLE_SUPPER_ADMIN", $u->getRoles())){
                        return $this->redirectToRoute('user_index');
                    }else{
                        return $this->redirectToRoute('dashboard');
                    }
                }

            }

            $entityManager->persist($user);
            $entityManager->flush();


            $u = $this->getUser();

            if (in_array("ROLE_SUPPER_ADMIN", $u->getRoles())){
                return $this->redirectToRoute('user_index');
            }else{
                return $this->redirectToRoute('user_show',["id" =>$u->getId()]);
            }

        }

        return $this->render('user/edit.html.twig', [
            'constance' => new Constance(),
            'user' => $user,
            'form' => $form->createView(),
            'edit' => true
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
