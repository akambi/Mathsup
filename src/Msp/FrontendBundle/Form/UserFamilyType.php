<?php

namespace Msp\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Msp\FrontendBundle\Form\Type\GenderType;

class UserFamilyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('sexe',new GenderType(), array( 'empty_value' => 'Choisir un genre',) )
            ->add('nom','text', array( 'attr' => array("placeholder" => "Votre nom"), 'required' => false))
            ->add('prenom','text', array( 'attr' => array("placeholder" => "Votre prénom"), 'required' => false))            
            //->add('numeroFixe', 'text', array( "label" => "Numéro Fixe", 'required' => false ) )
            //->add('numeroPortable', 'text', array( "label" => "Numéro Portable", 'required' => false ))
            //->add('email')
            //->add('user')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Msp\FrontendBundle\Entity\UserFamily'
        ));
    }

    public function getName()
    {
        return 'msp_frontendbundle_userfamilytype';
    }
}
