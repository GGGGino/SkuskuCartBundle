<?php

namespace GGGGino\SkuskuCartBundle\Controller;

use GGGGino\SkuskuCartBundle\Form\CartFlow;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProductInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends Controller
{
    /**
     * Cart page
     *
     * @Route("/cart", name="cart_page")
     */
    public function cartAction()
    {
        //$formData = new Vehicle(); // Your form data class. Has to be an object, won't work properly with an array.

        /** @var CartFlow $flow */
        $flow = $this->get('skusku.form.flow.cart'); // must match the flow's service id
        $flow->bind(null);

        // form of the current step
        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $em = $this->getDoctrine()->getManager();
                //$em->persist($formData);
                //$em->flush();

                $flow->reset(); // remove step data from the session

                return $this->redirect($this->generateUrl('cart_page')); // redirect when done
            }
        }

        return $this->render('GGGGinoSkuskuCartBundle::cart_page.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
        ));
    }

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
}
