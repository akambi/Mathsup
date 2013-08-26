<?php

namespace Msp\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Msp\FrontendBundle\Form\UserFamilyType;

class RegistrationProfesseurForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) { 
        switch ($options['flowStep']) {
            case 1:
                $builder
//                    ->add('username', null, array('label' => 'Pseudo :', 'attr' => array("placeholder" => "Pseudo") ))
                    ->add('email', 'email', array('label' => 'form.email', 'attr' => array("placeholder" => "Email")))
//                    ->add('plainPassword', 'repeated', array(
//                        'type' => 'password',
//                        'options' => array('translation_domain' => 'FOSUserBundle'),
//                        'first_options' => array('label' => 'form.password', 'attr' => array("placeholder" => "form.password")),
//                        'second_options' => array('label' => 'form.password_confirmation', 'attr' => array("placeholder" => "form.password_confirmation")),
//                        'invalid_message' => 'fos_user.password.mismatch',
//                    ))
                    ->add('nom', 'text', array( 'attr' => array("placeholder" => "Nom") ) )
                    ->add('prenom', 'text', array( 'attr' => array("placeholder" => "Prénom")))
                ;
                break;
            case 2:                
                $builder                    
                    ->add('email', 'email', array('label' => 'form.email', 'attr' => array("placeholder" => "Email")))
                    ->add('adresse', 'text', array( 'attr' => array("placeholder" => "Adresse")))                   
                    ->add('numeroPortable', 'text', array( 'label' => "Numéro de téléphone", 'attr' => array("placeholder" => "Numéro de téléphone"), 'required' => false ))
                    ->add('departement', 'entity', array( 'class' => 'Msp\FrontendBundle\Entity\Departement', 'empty_value' => "departement", 'required' => true))
                    ->add('ville', 'text', array( 'attr' => array("placeholder" => "Ville")))
                    ->add('dateDeNaissance', 'birthday', array('label' => "Date de naissance", 'widget' => 'single_text', 'attr' => array("placeholder" => "Date de naissance"), 'format' => 'dd/MM/yyyy'))                    
                ;  
                break;            
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Msp\UserBundle\Entity\User',
            'validation_groups' => array('registration'),
            'flowStep' => null,
        ));
    }

    public function getName() {
        return 'register_professeur';
    //  Pour utiliser le style dans form.field
        //return 'registration_eleve';
    }

}

?>
