<?php

namespace App\Controller;

use App\Entity\OrderStatus;
use App\Form\OrderStatusType;
use App\Repository\OrderStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order/status")
 */
class OrderStatusController extends AbstractController
{
    /**
     * @Route("/", name="order_status_index", methods={"GET"})
     */
    public function index(OrderStatusRepository $orderStatusRepository): Response
    {
        return $this->render('order_status/index.html.twig', [
            'order_statuses' => $orderStatusRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="order_status_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $orderStatus = new OrderStatus();
        $form = $this->createForm(OrderStatusType::class, $orderStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orderStatus);
            $entityManager->flush();

            return $this->redirectToRoute('order_status_index');
        }

        return $this->render('order_status/new.html.twig', [
            'order_status' => $orderStatus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_status_show", methods={"GET"})
     */
    public function show(OrderStatus $orderStatus): Response
    {
        return $this->render('order_status/show.html.twig', [
            'order_status' => $orderStatus,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="order_status_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OrderStatus $orderStatus): Response
    {
        $form = $this->createForm(OrderStatusType::class, $orderStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_status_index');
        }

        return $this->render('order_status/edit.html.twig', [
            'order_status' => $orderStatus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_status_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OrderStatus $orderStatus): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderStatus->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($orderStatus);
            $entityManager->flush();
        }

        return $this->redirectToRoute('order_status_index');
    }
}
