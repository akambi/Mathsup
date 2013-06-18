<?php

namespace Msp\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Msp\FrontendBundle\Form\Type\GenderType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {     
        parent::buildForm( $builder, $options );
        
        $builder
            ->add('sexe',new GenderType(), array( 'empty_value' => 'Choisir un genre',) )
            ->add('nom', 'text', array( "label" => "Nom de Famille"))
            ->add('prenom')
            ->add('departement')
            ->add('ville')
            ->add('etablissement')
            ->add('adresse')
            ->add('numeroFixe', 'text', array( "label" => "Numéro Fixe", 'required' => false ) )
            ->add('numeroPortable', 'text', array( "label" => "Numéro Portable", 'required' => false ))
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
            //->add('dateInscription', 'datetime', array('label' => "Date d'inscription", "with_seconds" => true, 'date_format' => 'dd/MM/yyyy'))
            ->add('classe', 'entity', array( "label"=> "Classe (A définir pour un élève)", 'class' => 'Msp\FrontendBundle\Entity\Classe', 'empty_value' => "Sélectionner une classe", 'required' => false))
        ;       
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults( array(
            'data_class' => 'Msp\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'msp_user_registration';
    }
}