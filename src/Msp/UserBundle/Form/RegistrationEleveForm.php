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
                    ->add('classe', 'entity', array( 'class' => 'Msp\FrontendBundle\Entity\Classe', 'empty_value' => "classe", 'required' => true))
                    ->add('dateDeNaissance', 'birthday', array('label' => "Date de naissance", 'widget' => 'single_text', 'attr' => array("placeholder" => "Date de naissance"), 'format' => 'dd/MM/yyyy'))
                ;
                $builder
                    ->add('userFamily', new UserFamilyType())
                ;
                $builder
                    ->add('objectifs', 'textarea', array('attr' => array("placeholder" => "Vos objectifs")))                    
                ;
                $builder
                    ->add('cours','choice', array( 
                        'choices'   => array(
                            '1'   => 'Cours à domicile',
                            '2' => 'Face à face',
                            '3' => 'classe virtuelle',
                        ),
                        'expanded' => true
                    ))
                    ->add('pack','choice', array( 
                        'choices'   => array(
                            '12'   => '12 H',
                            '24' => '24 H',
                            '36' => '36 H',
                            '48' => '48 H',
                        ),
                        'expanded' => true
                    ))                       
                ;
                break;
            /*case 3:
                $builder
                    ->add('userFamily', new UserFamilyType())
                ;
                break;
            case 4:
                $builder
                    ->add('objectifs', 'textarea', array('attr' => array("placeholder" => "Vos objectifs")))                    
                ;
                break;
            case 5:
                $builder
                    ->add('cours','choice', array( 
                        'choices'   => array(
                            '1'   => 'Cours à domicile',
                            '2' => 'Face à face',
                            '3' => 'classe virtuelle',
                        ),
                        'expanded' => true
                    ))
                    ->add('pack','choice', array( 
                        'choices'   => array(
                            '12'   => '12 H',
                            '24' => '24 H',
                            '36' => '36 H',
                            '48' => '48 H',
                        ),
                        'expanded' => true
                    ))                       
                ;
                break; */
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
        return 'register_eleve';
    //  Pour utiliser le style dans form.field
        //return 'registration_eleve';
    }

}

?>
