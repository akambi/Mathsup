<?php

namespace Msp\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('nom', 'text', array( "label" => "Nom de Famille"))
            ->add('prenom')
            ->add('departement')             
            ->add('roles', 'collection', array( 
                "type" => 'choice', 
                'options' => array( 
                    'choices' => array(
                        'ROLE_ELEVE' => 'Elève', 
                        'ROLE_PROFESSEUR' => 'Professeur', 
                        'ROLE_ADMIN' => 'Administrateur'
                        )
                    )
                )
            )
            ->add('classe')
        ;
    }

     public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Msp\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'msp_user_registration';
    }
}