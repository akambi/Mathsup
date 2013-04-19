<?php

namespace Msp\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('meetingName', 'text', array( "label" => "Titre de la conférence"))            
            ->add('moderatorPW', 'text', array( "label" => "Votre mot de passe"))
            ->add('attendeePW', 'text', array( "label" => "Le mot de passe des élèves"))            
            ->add('meetingDate', 'datetime', array( "label" => "Date et Heure de la conférence", "with_seconds" => true, 'date_format' => 'dd/MM/yyyy'))            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Msp\FrontendBundle\Entity\Conference'
        ));
    }

    public function getName()
    {
        return 'msp_frontendbundle_conferencetype';
    }
}
