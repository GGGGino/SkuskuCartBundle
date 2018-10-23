# SkuskuCartBundle

[![Total Downloads](https://poser.pugx.org/ggggino/skuskucart-bundle/downloads)](https://packagist.org/packages/ggggino/skuskucart-bundle)
[![Latest Stable Version](https://poser.pugx.org/ggggino/skuskucart-bundle/v/stable)](https://packagist.org/packages/ggggino/skuskucart-bundle)
![Travis (.org)](https://img.shields.io/travis/GGGGino/SkuskuCartBundle.svg)


Highly customizable cart management bundle for Symfony


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
    
    // Cart bundle
    new GGGGino\SkuskuCartBundle\GGGGinoSkuskuCartBundle(),
);
```

## Configuration

Bundle complete configuration

``` yml
# config.yml
ggggino_skuskucart:
    allow_anonymous_shop: false
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

Al posto delle entità es. "GGGGino\SkuskuCartBundle\Entity\SkuskuProduct" 
dovrai sostituire le tue entità effettive. Example

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


## Usage

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

### Cart page

> /cart

## Commands

> bin/console ggggino_skusku:cart:clear

Clear all the skuskutables

> bin/console ggggino_skusku:currency:create

Create a row of the given entity - DEV

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
``` 

## TODO

- API for creating cart
- Ordering stepform items

Test taken from: https://github.com/nelmio/NelmioApiDocBundle