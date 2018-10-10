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

Test taken from: https://github.com/nelmio/NelmioApiDocBundle