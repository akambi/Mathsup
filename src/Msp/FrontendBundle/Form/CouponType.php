<?php

namespace Msp\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CouponType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('token', 'textarea', array( 'attr'   =>  array( 'readonly'   => 'readonly')));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Msp\FrontendBundle\Entity\Coupon'
        ));
    }

    public function getName()
    {
        return 'msp_frontendbundle_coupontype';
    }
}
