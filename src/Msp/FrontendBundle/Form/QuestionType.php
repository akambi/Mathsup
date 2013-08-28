<?php

namespace Msp\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qcm')
            ->add('libelle', 'textarea', array( "label" => 'Titre'))
            ->add('illustration')
            ->add('duree', 'time', array( 'label' => 'Durée', "with_seconds" => true))
            //->add('date', 'datetime', array('extra_fields_message' => 'test', "with_seconds" => true, 'date_format' => 'dd/MM/yyyy'))
            //  Pour les relations 1-n
            ->add('reponses', 'collection', array("type" => new ReponseType, 'allow_add' => true, 'allow_delete' => true, 'by_reference' => false))
            //  Pour les relations 1-1
            //->add('reponses', new ReponseType, array("data_class" => null))
                
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Msp\FrontendBundle\Entity\Question'
        ));
    }

    public function getName()
    {
        return 'msp_frontendbundle_questiontype';
    }
}
