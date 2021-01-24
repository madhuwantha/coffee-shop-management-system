<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\CoffeeShop;
use App\Entity\Item;
use App\Form\ItemCollectionType;
use App\Form\ItemEditType;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/item")
 */
class ItemController extends AbstractController
{
    /**
     * @Route("/", name="item_index", methods={"GET"})
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param ItemRepository $itemRepository
     * @return Response
     */
    public function index(PaginatorInterface $paginator,Request $request,ItemRepository $itemRepository): Response
    {
        $query  = $itemRepository->findAll();
        $items = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('item/index.html.twig', [
            'constance' => new Constance(),
            'items' => $items,
        ]);
    }

    /**
     * @Route("/new/{id}", name="item_new", methods={"GET","POST"})
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function new(Request $request,Category $category): Response
    {
        $item = new Item();
        $form = $this->createForm(ItemCollectionType::class,$category);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $items = $form->get('items')->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $shop =  $entityManager->getRepository(CoffeeShop::class)->findOneBy(["menu" => $category->getMenu()]);
            foreach ($items as $item){
                $item->setShop($shop);
            }

            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('item_index');
        }

        return $this->render('item/new.html.twig', [
            'constance' => new Constance(),
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_show", methods={"GET"})
     */
    public function show(Item $item): Response
    {
        return $this->render('item/show.html.twig', [
            'constance' => new Constance(),
            'item' => $item,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="item_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Item $item): Response
    {
        $form = $this->createForm(ItemEditType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('item_index');
        }

        return $this->render('item/edit.html.twig', [
            'constance' => new Constance(),
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Item $item): Response
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($item);
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_index');
    }
}
