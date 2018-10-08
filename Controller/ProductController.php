<?php

namespace GGGGino\SkuskuCartBundle\Controller;

use Allyou\ManagementCafBundle\Entity\Product;
use GGGGino\SkuskuCartBundle\Form\AddToCartType;
use GGGGino\SkuskuCartBundle\Form\CartFlow;
use GGGGino\SkuskuCartBundle\Service\CRUDCart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Cart page
     *
     * @Route("/products", name="products_page")
     */
    public function productsAction(Request $request)
    {
        $productsAndForms = array();

        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        /** @var Product $product */
        foreach($products as $product) {
            $addToCartForm = $this->createForm(AddToCartType::class, array(
                'idProduct' => $product->getId()
            ));

            $addToCartForm->handleRequest($request);

            if ($addToCartForm->isSubmitted() && $addToCartForm->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $task = $addToCartForm->getData();

                var_dump($task);exit;

                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!
                // $entityManager = $this->getDoctrine()->getManager();
                // $entityManager->persist($task);
                // $entityManager->flush();

                return $this->redirectToRoute('products_page');
            }

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
        /** @var CRUDCart $crudCart */
        $crudCart = $this->get(CRUDCart::class);

        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            $product = $this->getRandomProduct();
        }

        $addToCartForm = $this->createForm(AddToCartType::class, array(
            'idProduct' => $id
        ));

        $addToCartForm->handleRequest($request);

        if ($addToCartForm->isSubmitted() && $addToCartForm->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $addToCartForm->getData();

            $crudCart->updateOrCreateCart($task);
            var_dump($task);exit;

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            return $this->redirectToRoute('products_page');
        }

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