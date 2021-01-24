<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\MessageReceived;
use App\Entity\MessageState;
use App\Entity\User;
use App\Form\MessageReceivedType;
use App\Form\MessageReplyType;
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
     * @Route("/sent-messages}", name="sent_messages", methods={"GET","POST"})
     * @param Request $request
     * @return string
     */
    public function sentMessages(Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $sentMessage = $entityManager->getRepository(Message::class)->findBy([
            "sender" => $user,
            "isReplyTo" => false
        ]);


        return $this->render('message/sent_index.html.twig', [
            'constance' => new Constance(),
            'messages' => $sentMessage,
//            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/", name="message_index", methods={"GET","POST"})
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param MessageRepository $messageRepository
     * @return Response
     * @throws \Exception
     */
    public function index(PaginatorInterface $paginator,Request $request,MessageRepository $messageRepository ): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $query  = $user->getMessageReceiveds();

//
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {


            $receiver = $form->get('messageReceiver')->getData();

            $messageState  = $entityManager->getRepository(MessageState::class)->findOneBy(['code' => "DELIVERED"]);

            $message->setSender($user);
            $senders = array();
            $message->setState($messageState);
            $message->setIsReplyTo(false);
            $message->setDate(new \DateTime());


            $messageReceived = new MessageReceived();
            $messageReceived->setMessage($message);
            $messageReceived->setReciever($receiver);

            $entityManager->persist($messageReceived);
            $entityManager->persist($message);


//            dump($message);
//            exit();
            $entityManager->flush();

            return $this->redirectToRoute('message_index');
        }



        $messages = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

//        dump($messages);
//        exit();
        return $this->render('message/index.html.twig', [
            'constance' => new Constance(),
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
            'constance' => new Constance(),
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_show", methods={"GET","POST"})
     * @param Message $message
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function show(Message $message, Request $request): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $replies = $entityManager->getRepository(Message::class)->findBy([
            "isReplyTo" => true,
            "replyTo" => $message
        ]);


        $user = $this->getUser();
        $reply = new Message();
        $form = $this->createForm(MessageReplyType::class, $reply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $message__ = $form->get('message')->getData();
            $messageState  = $entityManager->getRepository(MessageState::class)->findOneBy(['code' => "DELIVERED"]);
            $reply->setSender($user);
            $reply->setIsReplyTo(true);
            $reply->setMessage($message__);
            $reply->setState($messageState);
            $reply->setDate(new \DateTime());
            $reply->setReplyTo($message);
            $entityManager->persist($reply);
            $entityManager->flush();

            return $this->redirectToRoute('message_index');
        }


        return $this->render('message/show.html.twig', [
            'constance' => new Constance(),
            'message' => $message,
            'replies' =>$replies,
            'form' => $form->createView()
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
            'constance' => new Constance(),
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
