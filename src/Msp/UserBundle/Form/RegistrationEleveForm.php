<?php

namespace Msp\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Msp\FrontendBundle\Form\UserFamilyType;

class RegistrationEleveForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) { 
        switch ($options['flowStep']) {
            case 1:                
                //parent::buildForm( $builder, $options );
                $builder
                    ->add('username', null, array('label' => 'Pseudo :', 'attr' => array("placeholder" => "Pseudo") ))
                    ->add('email', 'email', array('label' => 'form.email', 'attr' => array("placeholder" => "Email")))
                    ->add('plainPassword', 'repeated', array(
                        'type' => 'password',
                        'options' => array('translation_domain' => 'FOSUserBundle'),
                        'first_options' => array('label' => 'form.password', 'attr' => array("placeholder" => "form.password")),
                        'second_options' => array('label' => 'form.password_confirmation', 'attr' => array("placeholder" => "form.password_confirmation")),
                        'invalid_message' => 'fos_user.password.mismatch',
                    ))
                    ->add('nom', 'text', array( 'attr' => array("placeholder" => "Nom") ) )
                    ->add('prenom', 'text', array( 'attr' => array("placeholder" => "Prénom")))                    
                    ->add('adresse', 'text', array( 'attr' => array("placeholder" => "Adresse")))                   
                    ->add('numeroPortable', 'text', array( 'label' => "Numéro de téléphone", 'attr' => array("placeholder" => "Numéro de téléphone"), 'required' => false ))
                    ->add('classe', 'entity', array( 'class' => 'Msp\FrontendBundle\Entity\Classe', 'empty_value' => "classe", 'required' => true))
                    ->add('dateDeNaissance', 'birthday', array('label' => "Date de naissance", 'widget' => 'single_text', 'attr' => array("placeholder" => "Date de naissance"), 'format' => 'dd/MM/yyyy'))
                ;
                break;
            case 2:
                $builder
                    ->add('userFamily', new UserFamilyType())
                ;
                break;
            case 3:
                $builder
                    ->add('objectifs', 'textarea', array('attr' => array("placeholder" => "Vos objectifs")))                    
                ;
                break;            
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Msp\UserBundle\Entity\User',
            'flowStep' => null,
        ));
    }

    public function getName() {
        return 'registration_eleve';
    }

}

?>
