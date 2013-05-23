<?php

namespace Msp\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Collection;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        $builder->add( 'nom', 'text', array( 'max_length' => 255 , 'label' => 'Nom: ') )
                ->add( 'prenom', 'text', array( 'max_length' => 255 , 'label' => 'Prénoms: ') )
                ->add( 'email', 'email', array( 'max_length' => 255 , 'label' => 'Email: ') )
                ->add( 'telephone', 'integer', array( 'label' => 'Téléphone: ', 'required' => false) )  
                ->add( 'objet', 'text', array( 'max_length' => 255 , 'label' => 'Objet: ') )
                ->add( 'message', 'textarea', array( 'label' => 'Message: ') );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $collectionConstraint = new Collection(array(            
            'nom' => new Length( array('min' => 3) ),
            'prenom' => new Length( array('min' => 3) ),
            'email' => new Email(array('message' => 'Email invalide')),
            'telephone' => new Length( array('min' => 5) ),
            'objet' => new Length( array('min' => 5) ),
            'message' => new Length( array('min' => 10) ),
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }

    public function getName()
    {
        return 'icls_boutiquebundle_contacttype';
    }
}

?>
