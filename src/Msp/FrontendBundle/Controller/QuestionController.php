<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Msp\FrontendBundle\Entity\Question;
use Msp\FrontendBundle\Form\QuestionType;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Question controller.
 *
 * @Route("/question")
 */
class QuestionController extends Controller
{
    /**
     * Lists all Question entities.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/", name="question")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $qcm  = new Question();
        $qcm_id = $request->query->get("qcm");
        
        $em = $this->getDoctrine()->getManager();
        if($qcm_id):
            $qcm = $em->getRepository('MspFrontendBundle:Qcm')->find($qcm_id);
            $entities = $qcm->getQuestions();
        else:
            $entities = $em->getRepository('MspFrontendBundle:Question')->findAll();
        endif;        

        return array(
            'entities' => $entities,
            'qcm' => $qcm,
        );
    }

    /**
     * Creates a new Question entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/", name="question_create")
     * @Method("POST")
     * @Template("MspFrontendBundle:Question:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Question();
        $form = $this->createForm(new QuestionType(), $entity);
        $form->bind($request);
        $qcm_id = $request->query->get("qcm");

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);           
            foreach ($entity->getReponses() as $response)
            {
                $response->setQuestion($entity);
                $em->persist($response);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('question_show', array('id' => $entity->getId(), 'qcm' => $qcm_id )));
        }
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'qcm_id' => $qcm_id
        );
    }

    /**
     * Displays a form to create a new Question entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/new", name="question_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $request = $this->getRequest();
        $qcm  = new Question();
        $qcm_id = $request->query->get("qcm");
        
        $em = $this->getDoctrine()->getManager();
        if($qcm_id):
            $qcm = $em->getRepository('MspFrontendBundle:Qcm')->find($qcm_id);
            $entity = new Question();
            $entity->setQcm($qcm);
        else:
            $entity = new Question();
        endif;        
        
        $form   = $this->createForm(new QuestionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'qcm_id' => $qcm_id,
        );
    }

    /**
     * Finds and displays a Question entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="question_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Question')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Question entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        
        $request = $this->getRequest();        
        $qcm_id = $request->query->get("qcm");
        
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'qcm_id' => $qcm_id,
        );
    }

    /**
     * Displays a form to edit an existing Question entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}/edit", name="question_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $request = $this->getRequest();        
        $qcm_id = $request->query->get("qcm");
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Question')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Question entity.');
        }

        $editForm = $this->createForm(new QuestionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'qcm_id' => $qcm_id,
        );
    }

    /**
     * Edits an existing Question entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="question_update")
     * @Method("PUT")
     * @Template("MspFrontendBundle:Question:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $qcm_id = $request->query->get("qcm");
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Question')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Question entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new QuestionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            foreach ($entity->getReponses() as $response)
            {
                $response->setQuestion($entity);
                $em->persist($response);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('question_edit', array('id' => $id, 'qcm' => $qcm_id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'qcm_id'      => $qcm_id,
        );
    }

    /**
     * Deletes a Question entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="question_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $qcm_id = $request->query->get("qcm");
        
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MspFrontendBundle:Question')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Question entity.');
            }
        //  On supprime d'abord les réponses            
            foreach ( $entity->getReponses() as $response )
            {
                $em->remove($response);
            }
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('question', array( 'qcm' => $qcm_id )));
    }

    /**
     * Creates a form to delete a Question entity by id.
     * @Secure(roles="ROLE_ADMIN")
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
