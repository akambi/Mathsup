<?php

namespace Msp\UserBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use Symfony\Component\Form\FormTypeInterface;

class RegistrationEleveFormFlow extends FormFlow {
    
    protected $allowDynamicStepNavigation = true;
    
    /**
     * @var FormTypeInterface
     */
    protected $formType;

    public function setFormType(FormTypeInterface $formType) {
        $this->formType = $formType;
    }
    
    public function getName() {
        return 'RegistrationEleve';
    }

    protected function loadStepsConfig() {
        return array(
            array(
                'label' => 'ESPACE ÉLÈVE',
                'type' => $this->formType,
            ),
            array(
                'label' => 'ESPACE PARENT',
                'type' => $this->formType,
                /*'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
                    return $estimatedCurrentStepNumber > 1 && !$flow->getFormData()->canHaveEngine();
                },*/
            ),
            array(
                'label' => 'VOS OBJECTIFS',
                'type' => $this->formType, 
            ),
            /*array(
                'label' => 'VOTRE FORMULE',
                'type' => $this->formType, 
            ),         
            array(
                'label' => 'confirmation',
                'type' => $this->formType, // needed to avoid InvalidOptionsException regarding option 'flowStep'
            ),*/
        );
    }

    public function getFormOptions($step, array $options = array()) {
        $options = parent::getFormOptions($step, $options);
        
        $options['flowStep'] = $step;
        
        return $options;
    }

}

?>
