<?php

namespace Msp\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Msp\FrontendBundle\Form\Type\GenderType;
use Msp\FrontendBundle\Form\UserFamilyType;

class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sexe',new GenderType(), array( 'empty_value' => 'Choisir un genre',) )
            ->add('nom')
            ->add('prenom')
            ->add('ville')
            ->add('departement')
            ->add('etablissement')
            ->add('adresse')
            ->add('numeroFixe', 'text', array( "label" => "Numéro Fixe", 'required' => false ) )
            ->add('numeroPortable', 'text', array( "label" => "Numéro Portable", 'required' => false ))
            ->add('classe')           
            ->add('userFamilies', 'collection', array("type" => new UserFamilyType, 'allow_add' => true, 'allow_delete' => true, 'by_reference' => false, 'label' => 'Parents'))
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
        return 'msp_userbundle_usertype';
    }
}
