<?php

namespace GGGGino\SkuskuCartBundle\Form\CartFlowType;

use GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProductBase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartStep1FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $validValues = array(2, 4);
        $tempProd = new SkuskuCartProduct();
        $data = array(
            $tempProd,
            $tempProd
        );
        $builder->add('numberOfWheels', CollectionType::class, array(
            //'data_class' => SkuskuCartProductBase::class,
            'data' => $data
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }

    public function getBlockPrefix()
    {
        return 'cartStep1';
    }
}