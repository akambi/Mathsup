<?php

namespace Msp\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QcmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', 'textarea', array( "label" => 'Titre'))
            ->add('duree', 'time', array( 'label' => 'Durée', "with_seconds" => true))
            ->add('date', 'datetime', array( "with_seconds" => true, 'date_format' => 'dd/MM/yyyy'))
            ->add('niveau')
            ->add('difficulter', 'entity', array( "label"=> "Difficulté", 'class' => 'Msp\FrontendBundle\Entity\Difficulter'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Msp\FrontendBundle\Entity\Qcm'
        ));
    }

    public function getName()
    {
        return 'msp_frontendbundle_qcmtype';
    }
}
