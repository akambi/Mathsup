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
            ->add('chapitre')
            ->add('exercice','textarea', array('label' => 'Rédaction de l\'excercice'))
            ->add('corrige','textarea', array('label' => 'Rédaction du corrigé'))
            ->add('file', 'file', array( "label" => "Selectionner un fichier PDF", 'required' => false))
            ->add('urlVideo', 'url', array( "label" => 'L\'url de la vidéo'))
            ->add('date', 'datetime', array('extra_fields_message' => 'test', "with_seconds" => true, 'date_format' => 'dd/MM/yyyy') )            
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
