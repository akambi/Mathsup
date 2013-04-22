<?php

namespace Msp\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Collection;

class BigBlueButtonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', 'text', array( "label" => 'Titre', "attr" =>array("placeholder"=>"Titre")))
            ->add('motdepasse','password', array( "label" => 'MOT DE PASSE', "attr" =>array("placeholder"=>"MOT DE PASSE")))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $collectionConstraint = new Collection(array(            
            'titre' => new Length( array('min' => 2) ),
            'motdepasse' => new Length( array('min' => 2) ),            
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }

    public function getName()
    {
        return 'msp_frontendbundle_bigbluebuttontype';
    }
}