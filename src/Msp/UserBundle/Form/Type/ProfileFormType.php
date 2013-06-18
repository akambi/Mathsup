<?php

namespace Msp\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraint\UserPassword;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProfileFormType extends BaseType
{
    private $container;
    
    public function __construct( ContainerInterface  $container, $class)
    {
        $this->container = $container;
        parent::__construct($class);
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {                     
        $user = $this->container->get('security.context')->getToken()->getUser();
        $roles = $user->getRoles();
    //  On récupère le rôle de l'utilisateur
        $first_role = $roles[0];        
        
        $builder->add('nom', 'text', array( "label" => "Nom de Famille"))
                ->add('prenom')
                ->add('departement')
                ->add('ville')
                ->add('etablissement')
                ->add('adresse')
                ->add('numeroFixe', 'text', array( "label" => "Numéro Fixe", 'required' => false ) )
                ->add('numeroPortable', 'text', array( "label" => "Numéro Portable", 'required' => false ))
        ;
        
        if( $first_role === "ROLE_ELEVE"):
            $builder->add('classe', 'entity', array( "label"=> "Classe (A définir pour un élève)", 
                                                    'class' => 'Msp\FrontendBundle\Entity\Classe', 
                                                    'empty_value' => "Sélectionner une classe", 
                                                    'required' => false)
            );
        endif;
        
        $builder->add('current_password', 'password', array(
            'label' => 'form.current_password',
            'translation_domain' => 'FOSUserBundle',
            'mapped' => false,
            'constraints' => new UserPassword(),
        ));
        
        //parent::buildForm($builder, $options);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Msp\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'msp_user_profile';
    }    
}
