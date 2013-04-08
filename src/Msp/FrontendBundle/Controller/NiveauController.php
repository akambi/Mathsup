<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Msp\FrontendBundle\Entity\Niveau;
use Msp\FrontendBundle\Form\NiveauType;

/**
 * Niveau controller.
 *
 * @Route("/niveau")
 */
class NiveauController extends Controller
{
    /**
     * Lists all Niveau entities.
     *
     * @Route("/", name="niveau")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MspFrontendBundle:Niveau')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Niveau entity.
     *
     * @Route("/", name="niveau_create")
     * @Method("POST")
     * @Template("MspFrontendBundle:Niveau:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Niveau();
        $form = $this->createForm(new NiveauType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('niveau_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Niveau entity.
     *
     * @Route("/new", name="niveau_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Niveau();
        $form   = $this->createForm(new NiveauType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Niveau entity.
     *
     * @Route("/{id}", name="niveau_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Niveau')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Niveau entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Niveau entity.
     *
     * @Route("/{id}/edit", name="niveau_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Niveau')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Niveau entity.');
        }

        $editForm = $this->createForm(new NiveauType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Niveau entity.
     *
     * @Route("/{id}", name="niveau_update")
     * @Method("PUT")
     * @Template("MspFrontendBundle:Niveau:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Niveau')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Niveau entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new NiveauType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('niveau_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Niveau entity.
     *
     * @Route("/{id}", name="niveau_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MspFrontendBundle:Niveau')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Niveau entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('niveau'));
    }

    /**
     * Creates a form to delete a Niveau entity by id.
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