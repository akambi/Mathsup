<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Msp\FrontendBundle\Entity\ExerciceCorrige;
use Msp\FrontendBundle\Form\ExerciceCorrigeType;

/**
 * ExerciceCorrige controller.
 *
 * @Route("/exercicecorrige")
 */
class ExerciceCorrigeController extends Controller
{
    /**
     * Lists all ExerciceCorrige entities.
     *
     * @Route("/", name="exercicecorrige")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MspFrontendBundle:ExerciceCorrige')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new ExerciceCorrige entity.
     *
     * @Route("/", name="exercicecorrige_create")
     * @Method("POST")
     * @Template("MspFrontendBundle:ExerciceCorrige:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new ExerciceCorrige();
        $form = $this->createForm(new ExerciceCorrigeType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('exercicecorrige_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new ExerciceCorrige entity.
     *
     * @Route("/new", name="exercicecorrige_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ExerciceCorrige();
        $form   = $this->createForm(new ExerciceCorrigeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ExerciceCorrige entity.
     *
     * @Route("/{id}", name="exercicecorrige_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:ExerciceCorrige')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExerciceCorrige entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ExerciceCorrige entity.
     *
     * @Route("/{id}/edit", name="exercicecorrige_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:ExerciceCorrige')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExerciceCorrige entity.');
        }

        $editForm = $this->createForm(new ExerciceCorrigeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ExerciceCorrige entity.
     *
     * @Route("/{id}", name="exercicecorrige_update")
     * @Method("PUT")
     * @Template("MspFrontendBundle:ExerciceCorrige:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:ExerciceCorrige')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExerciceCorrige entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ExerciceCorrigeType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('exercicecorrige_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ExerciceCorrige entity.
     *
     * @Route("/{id}", name="exercicecorrige_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MspFrontendBundle:ExerciceCorrige')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ExerciceCorrige entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('exercicecorrige'));
    }

    /**
     * Creates a form to delete a ExerciceCorrige entity by id.
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
