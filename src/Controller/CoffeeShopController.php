<?php

namespace App\Controller;

use App\Entity\CoffeeShop;
use App\Entity\SliderImage;
use App\Form\CoffeeShopType;
use App\Repository\CoffeeShopRepository;
use App\Service\FileUploader;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;


/**
 * @Route("/coffee/shop")
 */
class CoffeeShopController extends AbstractController
{
    /**
     * @Route("/", name="coffee_shop_index", methods={"GET"})
     * @param PaginatorInterface $paginator
     * @param CoffeeShopRepository $coffeeShopRepository
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator,CoffeeShopRepository $coffeeShopRepository,Request $request): Response
    {

//        $em = $this->getDoctrine()->getManager();
//        $repo = $em->getRepository(CoffeeShop::class);
//        $allAppointmentsQuery = $repo->createQueryBuilder('c')
//            ->select()
//            ->getQuery();


        $query  = $coffeeShopRepository->findAll();
        $coffeeShops = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            1
        );

        return $this->render('coffee_shop/index.html.twig', [
            'coffee_shops' =>$coffeeShops,
        ]);
    }

    /**
     * @Route("/new", name="coffee_shop_new", methods={"GET","POST"})
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $coffeeShop = new CoffeeShop();
        $form = $this->createForm(CoffeeShopType::class, $coffeeShop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $sliderImages = $form->get('sliderImages')->getData();

//            dump($sliderImages);
//            exit();
//
//            foreach ($sliderImages as $sliderImage){
//                $imageFileName = $fileUploader->upload($sliderImage);
//
////                $slI = new SliderImage();
////                $slI->setPosition()
//
//                $sliderImage->setPath($imageFileName);
//            }


            foreach ($coffeeShop->getMenu()->getCategories() as $category){
                $category->setLevel(1);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($coffeeShop);
            $entityManager->flush();

            return $this->redirectToRoute('coffee_shop_index');
        }

        $f = $form->createView();
//        dump($f);
//        exit();
        return $this->render('coffee_shop/new.html.twig', [
            'coffee_shop' => $coffeeShop,
            'form' => $f,
        ]);
    }

    /**
     * @Route("/{id}", name="coffee_shop_show", methods={"GET"})
     * @param CoffeeShop $coffeeShop
     * @return Response
     */
    public function show(CoffeeShop $coffeeShop): Response
    {
        return $this->render('coffee_shop/show.html.twig', [
            'coffee_shop' => $coffeeShop,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="coffee_shop_edit", methods={"GET","POST"})
     * @param Request $request
     * @param CoffeeShop $coffeeShop
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function edit(Request $request, CoffeeShop $coffeeShop, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(CoffeeShopType::class, $coffeeShop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $sliderImages = $form->get('sliderImages')->getData();
            foreach ($sliderImages as $sliderImage){
                $f = $sliderImage->getFile();
                $path = $fileUploader->upload($f);
                $sliderImage->setpath($path);
            }

            foreach ($coffeeShop->getMenu()->getCategories() as $category){
                $category->setLevel(1);
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('coffee_shop_index');
        }

        return $this->render('coffee_shop/edit.html.twig', [
            'coffee_shop' => $coffeeShop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="coffee_shop_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CoffeeShop $coffeeShop): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coffeeShop->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($coffeeShop);
            $entityManager->flush();
        }

        return $this->redirectToRoute('coffee_shop_index');
    }
}
