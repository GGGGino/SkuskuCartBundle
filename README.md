# SkuskuCartBundle

[![Total Downloads](https://poser.pugx.org/ggggino/skuskucart-bundle/downloads)](https://packagist.org/packages/ggggino/skuskucart-bundle)
[![Latest Stable Version](https://poser.pugx.org/ggggino/skuskucart-bundle/v/stable)](https://packagist.org/packages/ggggino/skuskucart-bundle)
![Travis (.org)](https://api.travis-ci.com/GGGGino/SkuskuCartBundle.svg)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GGGGino/SkuskuCartBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/GGGGino/SkuskuCartBundle/?branch=master)


Highly customizable cart management bundle for Symfony.
The archievement of this cart manager is to do something like:


> **Add this *thing* to a *cart***


## License

[![License](https://poser.pugx.org/ggggino/skuskucart-bundle/license)](LICENSE)

## Installation

**1**  Add bundle to your vendor

``` shell
composer require ggggino/skuskucart-bundle
``` 

**2** Register the bundle in ``app/AppKernel.php``

``` php
$bundles = array(
    // ...
    
    // Multi step form
    new Craue\FormFlowBundle\CraueFormFlowBundle(),
    
    // Payment bundle
    new Payum\Bundle\PayumBundle\PayumBundle(),
    
    // Cart bundle
    new GGGGino\SkuskuCartBundle\GGGGinoSkuskuCartBundle(),
);
```

**3** Create at least one currency

``` shell
bin/console ggggino_skusku:currency:create
``` 

**4** Set default locale and currency

``` yml
parameters:
    locale: it
    currency: EUR
```


## Configuration

Bundle complete configuration

``` yml
# config.yml
ggggino_skuskucart:
    allow_anonymous_shop: false
    cart_mode: 'single_page'
    stepform:
        cart:
            form_type: GGGGino\SkuskuCartBundle\Form\CartFlowType\CartStep1FormType
            label: Step 1
        chosePayment:
            form_type: GGGGino\SkuskuCartBundle\Form\CartFlowType\CartStep2FormType
            label: Step 2
        payment:
            form_type: GGGGino\SkuskuCartBundle\Form\CartFlowType\CartStep3FormType
            label: Step 3
    templates:
        cart_layout: 'GGGGinoSkuskuCartBundle::cart_page.html.twig'
        done_layout: 'xxxBundle:xxx:xxx.html.twig'
``` 

Extra configs

``` yml
# config.yml
parameters:
    locale: it
    currency: EUR
``` 

Add the target entities that replace the interfaces

``` yml
# config.yml
doctrine:
    orm:
        resolve_target_entities:
              GGGGino\SkuskuCartBundle\Model\SkuskuProductInterface: GGGGino\SkuskuCartBundle\Entity\SkuskuProduct
              GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface: GGGGino\SkuskuCartBundle\Entity\SkuskuUser
              GGGGino\SkuskuCartBundle\Model\SkuskuCurrencyInterface: GGGGino\SkuskuCartBundle\Entity\SkuskuCurrency
              GGGGino\SkuskuCartBundle\Model\SkuskuLangInterface: GGGGino\SkuskuCartBundle\Entity\SkuskuLanguage
``` 

Add the basics routes

``` yml
# routing.yml
skusku:
    resource: "@GGGGinoSkuskuCartBundle/Controller/"
    type:     annotation
``` 

Use `resolve_target_entities` to replace the interface entities with the concrete ones

``` yml
doctrine:
    orm:
        resolve_target_entities:
              GGGGino\SkuskuCartBundle\Model\SkuskuProductInterface: AppBundle\Entity\Product
              GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface: AnotherBundle\Entity\User
              GGGGino\SkuskuCartBundle\Model\SkuskuCurrencyInterface: My\CustomBundle\Entity\Currency
              GGGGino\SkuskuCartBundle\Model\SkuskuLangInterface: ExtraBundle\Entity\Language
``` 

> Every class used must implements the right interface.

1. Currency
   ``` php
   use GGGGino\SkuskuCartBundle\Model\SkuskuCurrencyInterface;
   
   class Currency implements SkuskuCurrencyInterface
   {
   }
   ``` 

2. User
   ``` php
   use GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface;
   
   class User implements SkuskuCustomerInterface
   {
   }
   ``` 

3. Product
   ``` php
   use GGGGino\SkuskuCartBundle\Model\SkuskuProductInterface;
   
   class Product implements SkuskuProductInterface
   {
   }
   ``` 

4. Language
   ``` php
   use GGGGino\SkuskuCartBundle\Model\SkuskuLangInterface;
   
   class Lang implements SkuskuLangInterface
   {
   }
   ``` 
   
> If you want an prebuilt entity you can extend their own base class.

1. Currency
   ``` php
   use GGGGino\SkuskuCartBundle\Model\SkuskuCurrencyBase;
   class Currency extends SkuskuCurrencyBase
   {
   }
   ``` 


## Twig functions

### Print the cart preview

``` twig
{{ render_preview_cart() }}
``` 

### Print the language choice block

``` twig
{{ render_lang_cart() }}
``` 

### Print the currency choice block

``` twig
{{ render_currency_cart() }}
``` 


## CartManager API

### Cart manager
Get the cart manager instance
``` php
use GGGGino\SkuskuCartBundle\Service\CartManager;
.
.
.
$cartManager = $this->get(CartManager::class);
``` 

### CartManager::persistCart(SkuskuCart $cart)
Add the cart to EntityManager
``` php
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
.
.
.
/** @var SkuskuCart $finalCart */
$finalCart = ...

$cartManager->persistCart($finalCart);
``` 

### CartManager::flushCart(SkuskuCart $cart);
Flush the cart
``` php
$cartManager->flushCart($finalCart);
``` 

### CartManager::addProductToCart(SkuskuProductInterface $product, int $quantity)
Add some product to the cart
``` php
$quantity = 20;
$cartManager->addProductToCart($product, $quantity);
``` 

### CartManager::createNewCart(SkuskuCustomerInterface $customer = null)
Create new Cart from a given customer, if the customer is not passed is taken from the session
``` php
$cartManager->createNewCart($customer);
``` 

### CartManager::createNewOrderFromCart(SkuskuCart $cart)
Build a new Order from a given cart. Used for example when the payment gone good
``` php
$cartManager->createNewOrderFromCart($cart);
``` 

### Cart page

> /cart

## Commands

> bin/console ggggino_skusku:cart:clear

Clear all the skuskutables

> bin/console ggggino_skusku:currency:create

Create a row of the given entity - DEV

> bin/console ggggino_skusku:doctor:db

Check if the installation procedure was successful

## Configuration details

You can decide if even the anonymous user can shop

``` yml
# config.yml
ggggino_skuskucart:
    allow_anonymous_shop: false
``` 

Chose between use the default steps and create new ones,
remember that for the "cart|chosePayment|payment" you can only override
configs

``` yml
# config.yml
ggggino_skuskucart:
    stepform:
        cart:
            form_type: GGGGino\SkuskuCartBundle\Form\CartFlowType\CartStep1FormType
            label: Step 1
        chosePayment:
            form_type: GGGGino\SkuskuCartBundle\Form\CartFlowType\CartStep2FormType
            label: Step 2
        payment:
            form_type: GGGGino\SkuskuCartBundle\Form\CartFlowType\CartStep3FormType
            label: Step 3
``` 

If you need more customization in the formstep you can override it.
Your CartFlow needs only to inherit 

``` yml
# config.yml
ggggino_skuskucart:
    stepform_class: GGGGino\SkuskuCartBundle\Form\CartFlow
``` 

If you need to change the templates

``` yml
# config.yml
ggggino_skuskucart:
    templates:
        cart_layout: 'GGGGinoSkuskuCartBundle::cart_page.html.twig'
        done_layout: 'xxxBundle:xxx:xxx.html.twig'
``` 

## Verifiers

The verifiers are a custom service to retrieve the token from the request when this one
is not directly available in the query string.
It is used in the "done" action when the gateway does not return the url you setted.
For example gestpay will not return the passed token, instead it pass in the query-string a "gestpay token"
that needs to be decripted and at this point you can take the payum payment token

When you create a Verifier, the system adds it to the available-list.
If no verifier will be found then the payum core one will be used.

```yaml
GGGGino\SkuskuCartBundle\Gateway\Verifiers\GestPayVerifier:
        public: false
        tags:
            - { name: ggggino_skuskucart.request_verifier}
```

```php
<?php

namespace GGGGino\SkuskuCartBundle\Gateway\Verifiers;

use GGGGino\SkuskuCartBundle\Model\SkuskuPaymentToken;
use GGGGino\SkuskuCartBundle\Service\RequestVerifierInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Payum;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

class GestPayVerifier implements RequestVerifierInterface
{
    /** @var \Doctrine\ORM\EntityManager $entityManager */
    protected $em;


    /**
     * Obviously $em is not required but if you want to search in the db you have to use it
     * GestPayVerifier constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @inheritdoc
     */
    public function verify(Request $request, $extra = null)
    {
        /** @var string $token Con questo token puoi cercare sul db il payment e da li fare il return del SkuskuPaymentToken trovato */
        $token = $request->query->get('b');

        $skuskuPaymentToken = $this->em->getRepository(SkuskuPaymentToken::class)->findOneByHash($token);

        return $skuskuPaymentToken;
    }

    /**
     * @inheritdoc
     */
    public function supports(Request $request)
    {
        return true;
    }
}
```

> Verifiers must implement `RequestVerifierInterface`.

#### `RequestVerifierInterface::supports(Request $request)`

This method is used to check if the verifier should be used. 

#### `RequestVerifierInterface::verify(Request $request, $extra = null)`

This method is used to retrieve the right token from the request.

## Events

| Name | Constant | Argument passed | Description |
| --- | --- | --- | ---|
| skusku_cart.pre_submit | `CartFlow::PRE_SUBMIT` | `CartForm` | Here you can modify entities or do custom action before the persist |
| skusku_cart.post_submit | `CartFlow::POST_SUBMIT` | `CartForm` | Here you can do custom action after the persist |
| skusku_cart.post_payment | `CartFlow::POST_PAYMENT` | `SkuskuPayment`, $status | Here you can do "anything" after the payment response |
| skusku_cart.pre_persist_order | `CartFlow::PRE_PERSIST_ORDER` | `SkuskuOrder` | Here you can manipulate the Order before the persist |

## Templates

| Name | Arguments | Default | Description |
| --- | --- | --- | ---|
| skusku_cart.templates.cart_layout | Form, FormFlow | `GGGGinoSkuskuCartBundle::cart_page.html.twig` | Set the template that render the cart page |
| skusku_cart.templates.done_layout | Status, Payment | null | Set the template used after the payment was done |

## TODO

- API for creating cart
- Ordering stepform items

Test taken from: https://github.com/nelmio/NelmioApiDocBundle