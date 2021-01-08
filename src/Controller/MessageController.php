<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\MessageReceived;
use App\Entity\User;
use App\Form\MessageReceivedType;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/{id}", name="message_index", methods={"GET","POST"})
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param MessageRepository $messageRepository
     * @param User $user
     * @return Response
     */
    public function index(PaginatorInterface $paginator,Request $request,MessageRepository $messageRepository, User $user ): Response
    {
        $query  = $user->getMessageReceiveds();
        $messageReceived = new MessageReceived();
        $form = $this->createForm(MessageReceivedType::class, $messageReceived);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($messageReceived);
            $entityManager->flush();

            return $this->redirectToRoute('message_index');
        }

        $messages = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            1
        );
        return $this->render('message/index.html.twig', [
            'messages' => $messages,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/new", name="message_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('message_index');
        }

        return $this->render('message/new.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_show", methods={"GET"})
     */
    public function show(Message $message): Response
    {
        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Message $message): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_index');
        }

        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('message_index');
    }
}
