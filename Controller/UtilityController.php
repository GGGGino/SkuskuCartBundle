<?php

namespace GGGGino\SkuskuCartBundle\Controller;

use GGGGino\SkuskuCartBundle\Form\CartFlow;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProductInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UtilityController
 * @package GGGGino\SkuskuCartBundle\Controller
 */
class UtilityController extends Controller
{
    /**
     * Cart page
     *
     * @Route("/remove_item/{product}", name="remove_item_from_cart")
     */
    public function removeItemFromCart(SkuskuCartProduct $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return new Response('ok');
    }
    /**
     * Cart page
     *
     * @Route("/update_item/{product}", name="update_item_in_cart", methods={"POST"})
     */
    public function updateItemInCart(Request $request, SkuskuCartProduct $product)
    {
        $em = $this->getDoctrine()->getManager();
        $product->setQuantity(intval($request->request->get('quantity')));
        $em->flush();

        return new Response('ok');
    }
}