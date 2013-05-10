<?php

namespace Msp\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserHourlyRateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user')
            ->add('cours')
            ->add('niveau')  
            ->add('tauxHoraire')  
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Msp\FrontendBundle\Entity\UserHourlyRate'
        ));
    }

    public function getName()
    {
        return 'msp_frontendbundle_userhourlyratetype';
    }
}
