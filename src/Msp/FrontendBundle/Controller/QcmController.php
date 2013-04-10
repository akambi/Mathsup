<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Msp\FrontendBundle\Entity\Qcm;
use Msp\FrontendBundle\Form\QcmType;

/**
 * Qcm controller.
 *
 * @Route("/qcm")
 */
class QcmController extends Controller
{
    /**
     * Lists all Qcm entities.
     *
     * @Route("/", name="qcm")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MspFrontendBundle:Qcm')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Qcm entity.
     *
     * @Route("/", name="qcm_create")
     * @Method("POST")
     * @Template("MspFrontendBundle:Qcm:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Qcm();
        $form = $this->createForm(new QcmType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('qcm_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Qcm entity.
     *
     * @Route("/new", name="qcm_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Qcm();
        $form   = $this->createForm(new QcmType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Qcm entity.
     *
     * @Route("/{id}", name="qcm_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Qcm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Qcm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Qcm entity.
     *
     * @Route("/{id}/edit", name="qcm_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Qcm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Qcm entity.');
        }

        $editForm = $this->createForm(new QcmType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Qcm entity.
     *
     * @Route("/{id}", name="qcm_update")
     * @Method("PUT")
     * @Template("MspFrontendBundle:Qcm:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Qcm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Qcm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new QcmType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('qcm_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Qcm entity.
     *
     * @Route("/{id}", name="qcm_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MspFrontendBundle:Qcm')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Qcm entity.');
            }
            
        //  On supprime d'abord les questions
            foreach ( $entity->getQuestions() as $question )
            {
                foreach ( $question->getReponses() as $response )
                {
                    $em->remove($response);
                }
                
                $em->remove($question);
            }
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('qcm'));
    }

    /**
     * Creates a form to delete a Qcm entity by id.
     *
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
