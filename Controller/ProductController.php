<?php

namespace GGGGino\SkuskuCartBundle\Controller;

use Allyou\ManagementCafBundle\Entity\Product;
use GGGGino\SkuskuCartBundle\Form\AddToCartType;
use GGGGino\SkuskuCartBundle\Form\CartFlow;
use GGGGino\SkuskuCartBundle\Model\SkuskuProductInterface;
use GGGGino\SkuskuCartBundle\Service\CartManager;
use GGGGino\SkuskuCartBundle\Service\CRUDCart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProductController
 * @package GGGGino\SkuskuCartBundle\Controller
 */
class ProductController extends Controller
{
    /**
     * Cart page
     *
     * @Route("/products", name="products_page")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function productsAction(Request $request)
    {
        /** @var CartManager $cartManager */
        $cartManager = $this->get(CartManager::class);

        $productsAndForms = array();

        $products = $this->getDoctrine()
            ->getRepository(SkuskuProductInterface::class)
            ->findAll();

        /** @var SkuskuProductInterface $product */
        foreach($products as $product) {
            /** @var Form $addToCartForm */
            $addToCartForm = $this->createForm(AddToCartType::class, array(
                'idProduct' => $product->getId()
            ));

            $cartManager->addProductToCartForm($request, $addToCartForm);

            $productsAndForms[] = array(
                'product' => $product,
                'form' => $addToCartForm->createView()
            );
        }

        return $this->render('GGGGinoSkuskuCartBundle::products.html.twig', array(
            'productsForms' => $productsAndForms
        ));
    }

    /**
     * Cart page
     *
     * @Route("/products/{id}", name="product_page")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function productAction(Request $request, $id)
    {
        /** @var CartManager $cartManager */
        $cartManager = $this->get(CartManager::class);

        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            $product = $this->getRandomProduct();
        }

        $addToCartForm = $this->createForm(AddToCartType::class, array(
            'idProduct' => $id
        ));

        $cartManager->addProductToCartForm($request, $addToCartForm);

        return $this->render('GGGGinoSkuskuCartBundle::product.html.twig', array(
            'product' => $product,
            'addToCartForm' => $addToCartForm->createView()
        ));
    }

    private function getRandomProduct()
    {
        $ieri = new \DateTime();
        $productItem = new Product();
        $productItem->setDescription(MD5(microtime()));
        $productItem->setFullPrice(rand(0, 100));
        $productItem->setAvailableFrom($ieri->sub(new \DateInterval('P1D')));
        $productItem->setAvailableTo($ieri->add(new \DateInterval('P1D')));

        return $productItem;
    }

}