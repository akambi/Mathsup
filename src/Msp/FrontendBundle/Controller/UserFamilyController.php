<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Msp\FrontendBundle\Entity\UserFamily;
use Msp\FrontendBundle\Form\UserFamilyType;

/**
 * UserFamily controller.
 *
 * @Route("/userfamily")
 */
class UserFamilyController extends Controller
{
    /**
     * Lists all UserFamily entities.
     *
     * @Route("/", name="userfamily")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MspFrontendBundle:UserFamily')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new UserFamily entity.
     *
     * @Route("/", name="userfamily_create")
     * @Method("POST")
     * @Template("MspFrontendBundle:UserFamily:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new UserFamily();
        $form = $this->createForm(new UserFamilyType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('userfamily_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new UserFamily entity.
     *
     * @Route("/new", name="userfamily_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new UserFamily();
        $form   = $this->createForm(new UserFamilyType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a UserFamily entity.
     *
     * @Route("/{id}", name="userfamily_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:UserFamily')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserFamily entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing UserFamily entity.
     *
     * @Route("/{id}/edit", name="userfamily_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:UserFamily')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserFamily entity.');
        }

        $editForm = $this->createForm(new UserFamilyType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing UserFamily entity.
     *
     * @Route("/{id}", name="userfamily_update")
     * @Method("PUT")
     * @Template("MspFrontendBundle:UserFamily:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:UserFamily')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserFamily entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UserFamilyType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('userfamily_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a UserFamily entity.
     *
     * @Route("/{id}", name="userfamily_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MspFrontendBundle:UserFamily')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserFamily entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('userfamily'));
    }

    /**
     * Creates a form to delete a UserFamily entity by id.
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
