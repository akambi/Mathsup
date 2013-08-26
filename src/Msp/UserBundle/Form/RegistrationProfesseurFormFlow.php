<?php

namespace Msp\UserBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use Symfony\Component\Form\FormTypeInterface;
use Msp\UserBundle\Form\RegistrationProfesseurForm;

class RegistrationProfesseurFormFlow extends FormFlow {
    
    protected $allowDynamicStepNavigation = true;
    
    /**
     * @var FormTypeInterface
     */
    protected $formType;

    public function setFormType(FormTypeInterface $formType) {
        $this->formType = $formType;
    }
    
    public function getName() {
        return 'RegistrationProfesseur';
    }

    protected function loadStepsConfig() {
        return array(
            array(
                'label' => 'ESPACE PROFESSEUR',
                'type' => new RegistrationProfesseurForm(),
            ),
            array(
                'label' => 'ESPACE PROFESSEUR SUITE',
                'type' => new RegistrationProfesseurForm(),
            ),            
            
        );
    }

    public function getFormOptions($step, array $options = array()) {
        $options = parent::getFormOptions($step, $options);
        
        $options['flowStep'] = $step;
        
        return $options;
    }

}

?>
