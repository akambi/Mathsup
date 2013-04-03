<?php

namespace Msp\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExerciceCorrigeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('exercice')
            ->add('corrige')
            ->add('urlPdf')
            ->add('urlVideo')
            ->add('date')
            ->add('chapitre')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Msp\FrontendBundle\Entity\ExerciceCorrige'
        ));
    }

    public function getName()
    {
        return 'msp_frontendbundle_exercicecorrigetype';
    }
}
