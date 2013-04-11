<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Msp\FrontendBundle\Entity\Difficulter;
use Msp\FrontendBundle\Form\DifficulterType;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Difficulter controller.
 *
 * @Route("/difficulter")
 */
class DifficulterController extends Controller
{
    /**
     * Lists all Difficulter entities.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/", name="difficulter")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MspFrontendBundle:Difficulter')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Difficulter entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/", name="difficulter_create")
     * @Method("POST")
     * @Template("MspFrontendBundle:Difficulter:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Difficulter();
        $form = $this->createForm(new DifficulterType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('difficulter_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Difficulter entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/new", name="difficulter_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Difficulter();
        $form   = $this->createForm(new DifficulterType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Difficulter entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="difficulter_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Difficulter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Difficulter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Difficulter entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}/edit", name="difficulter_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Difficulter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Difficulter entity.');
        }

        $editForm = $this->createForm(new DifficulterType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Difficulter entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="difficulter_update")
     * @Method("PUT")
     * @Template("MspFrontendBundle:Difficulter:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Difficulter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Difficulter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new DifficulterType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('difficulter_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Difficulter entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="difficulter_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MspFrontendBundle:Difficulter')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Difficulter entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('difficulter'));
    }

    /**
     * Creates a form to delete a Difficulter entity by id.
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
