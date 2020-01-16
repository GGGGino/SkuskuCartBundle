<?php

namespace GGGGino\SkuskuCartBundle\Form\CartFlowType;

use GGGGino\SkuskuCartBundle\Form\Type\CartProductType;
use Payum\Core\Bridge\Symfony\Form\Type\GatewayChoiceType;
use Payum\Core\Bridge\Symfony\Form\Type\GatewayFactoriesChoiceType;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use Payum\Core\Bridge\Symfony\Form\Type\CreditCardType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartSinglePageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cartProducts', CollectionType::class, array(
            'entry_type' => CartProductType::class,
            'label' => false,
            'attr' => array(
                'class' => 'step1'
            )
        ))
        ->add('getTotalQuantity', IntegerType::class, array(
            'label' => 'get_total_quantity',
            'disabled' => true
        ))
        ->add('getTotalPrice', MoneyType::class, array(
            'label' => 'get_total_price',
            'disabled' => true
        ));

        $builder->add('paymentMethod', GatewayChoiceType::class, array(
            'label' => 'payment_method'
        ));  

        $builder->add('engine', CreditCardType::class, array(
            'mapped' => false
        ));              
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

    public function getBlockPrefix()
    {
        return 'cartSinglePage';
    }
}