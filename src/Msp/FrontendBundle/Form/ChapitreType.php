<?php

namespace Msp\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChapitreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', 'textarea', array( "label" => 'Titre') )
            ->add('date', 'datetime', array('extra_fields_message' => 'test', "with_seconds" => true, 'date_format' => 'dd/MM/yyyy'))
            ->add('niveau')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Msp\FrontendBundle\Entity\Chapitre'
        ));
    }

    public function getName()
    {
        return 'msp_frontendbundle_chapitretype';
    }
}
