<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\CoffeeShop;
use App\Entity\Gallery;
use App\Entity\GalleryImage;
use App\Entity\GalleryVideo;
use App\Entity\Item;
use App\Entity\SliderImage;
use App\Entity\Theme;
use App\Form\CoffeeShopType;
use App\Repository\CoffeeShopRepository;
use App\Service\FileUploader;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Security;


/**
 * @Route("/coffee/shop")
 */
class CoffeeShopController extends AbstractController
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
     * @Route("/shop/{shop_id}", name="shop")
     * @param $shop_id
     * @return Response
     */
    public function shopIndex($shop_id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $coffeeShop = $em->getRepository(CoffeeShop::class)->find($shop_id);

        $themeCode  = $coffeeShop->getTheme()->getCode();
        $menu = $coffeeShop->getMenu();



        $categories = $em->getRepository(Category::class)->findBy(["menu" => $menu, "level" => 1]) ;

        $gallery  = $em->getRepository(Gallery::class)->findOneBy(['coffee_shop' => $coffeeShop]);

        $imageGallery =$em->getRepository(GalleryImage::class)->findBy(['gallery' => $gallery]);
        $videoGallery =$em->getRepository(GalleryVideo::class)->findBy(['gallery' => $gallery]);


//        $products = $em->getRepository(Item::class)->findBy(['isInHomePage' => true, ""]);

        $sendCategories = array();
        foreach ($categories as $category){
            $nextCategories = $em->getRepository(Category::class)->findBy([
               "parentCategory" => $category,
               "level" => 2
            ]);
            array_push($sendCategories,array(
                "category" => $category,
                "subCategories" => $nextCategories,
            ));
        }



//        switch ($themeCode){
//            case 'TWO':
//                return $this->render('shop/two/index.html.twig', [
//                    'controller_name' => 'ShopController',
//                    'shop' => $coffeeShop
//                ]);
//            case 'ONE':
////            default:
////                return $this->render('themes/one/one_index.html.twig', [
////                    'controller_name' => 'ShopController',
////                    'shop' => $coffeeShop
////                ]);
//        }


        return $this->render('coffee_shop/one_index.html.twig', [
            'controller_name' => 'ShopController',
            'shop' => $coffeeShop,
            'categories' => $sendCategories,
            'imageGallery' => $imageGallery,
            'videoGallery' => $videoGallery
        ]);
    }


    /**
     * @Route("/", name="coffee_shop_index", methods={"GET"})
     * @param PaginatorInterface $paginator
     * @param CoffeeShopRepository $coffeeShopRepository
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator,CoffeeShopRepository $coffeeShopRepository,Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user = $this->security->getUser();

        $query = "";
        if (in_array("ROLE_SUPPER_ADMIN", $user->getRoles())){
            $query  = $coffeeShopRepository->findAll();
        }else{
            $query  = $coffeeShopRepository->findBy(array("owner" => $user));
        }


        $coffeeShops = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
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

        $this->denyAccessUnlessGranted('ROLE_SUPPER_ADMIN');

        $coffeeShop = new CoffeeShop();
        $form = $this->createForm(CoffeeShopType::class, $coffeeShop);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        $teams = $entityManager->getRepository(Theme::class)->findAll();

        if ($form->isSubmitted() && $form->isValid()) {

            $coverPhoto = $form->get('coverPhoto')->getData();
            $path = $fileUploader->upload($coverPhoto->getFile());
            $coverPhoto->setPath($path);

            $menu = $form->get('menu')->getData();
            $menu->setName($coffeeShop->getName()."_MENU");

            $sliderImages = $form->get('sliderImages')->getData();
            foreach ($sliderImages as $sliderImage){
                $f = $sliderImage->getFile();
                $path = $fileUploader->upload($f);
                $sliderImage->setpath($path);
            }

            foreach ($coffeeShop->getMenu()->getCategories() as $category){
                $category->setLevel(1);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($coffeeShop);
            $entityManager->flush();

            return $this->redirectToRoute('coffee_shop_index');
        }

        $f = $form->createView();
        return $this->render('coffee_shop/new.html.twig', [
            'coffee_shop' => $coffeeShop,
            'form' => $f,
            'themes' => $teams
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

        $entityManager = $this->getDoctrine()->getManager();
        $teams = $entityManager->getRepository(Theme::class)->findAll();
        if ($form->isSubmitted() && $form->isValid()) {


            $sliderImages = $form->get('sliderImages')->getData();
            foreach ($sliderImages as $sliderImage){
                $f = $sliderImage->getFile();
                if ($f != null){
                    $path = $fileUploader->upload($f);
                    $sliderImage->setpath($path);
                }
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
            'themes' => $teams
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
