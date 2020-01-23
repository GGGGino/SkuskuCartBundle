<?php

namespace GGGGino\SkuskuCartBundle\Form\Type;

use GGGGino\SkuskuCartBundle\Model\SkuskuCartProductInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdditionalFieldsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        foreach ($options['fields'] as $field) {
            $class = 'Symfony\Component\Form\Extension\Core\Type\\'.$field['type'] .'Type';

            $cssClass = null !== $field['class'] ? $field['class'] : '';

            $builder
                ->add($field['id'], $class, array(
                    'label' => $field['label'],
                    'required' => $field['required'],
                    'attr' => array(
                        'class' => $cssClass
                    )
                ));

            if($field['data'] !== null) {
                $builder->get($field['id'])->setData( true );
            }
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(
            'fields' => array(),
            'label' => false,
            'class' => false,
            'required' => true,
            'data' => null,            
        ));
    }
}