# SkuskuCartBundle

[![Latest Stable Version](https://poser.pugx.org/ggggino/skuskucart-bundle/v/stable)](https://packagist.org/packages/ggggino/skuskucart-bundle)

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
    new GGGGino\SkuskuCartBundle\GGGGinoSkuskuCartBundle(),
);
```

## Configuration

``` yml
parameters:
    locale: it
    currency: EUR
``` 

Add the target entities that replace the interfaces

``` yml
doctrine:
    orm:
        resolve_target_entities:
              GGGGino\SkuskuCartBundle\Model\SkuskuProductInterface: GGGGino\SkuskuCartBundle\Entity\SkuskuProduct
              GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface: GGGGino\SkuskuCartBundle\Entity\SkuskuUser
              GGGGino\SkuskuCartBundle\Model\SkuskuCurrencyInterface: GGGGino\SkuskuCartBundle\Entity\SkuskuCurrency
              GGGGino\SkuskuCartBundle\Model\SkuskuLangInterface: GGGGino\SkuskuCartBundle\Entity\SkuskuLanguage
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

Test taken from: https://github.com/nelmio/NelmioApiDocBundle