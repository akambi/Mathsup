<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Msp\FrontendBundle\Entity\Cours;
use Msp\FrontendBundle\Form\CoursType;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Cours controller.
 *
 * @Route("/cours")
 */
class CoursController extends Controller
{
    /**
     * Lists all Cours entities.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/", name="cours")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MspFrontendBundle:Cours')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Cours entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/", name="cours_create")
     * @Method("POST")
     * @Template("MspFrontendBundle:Cours:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Cours();
        $form = $this->createForm(new CoursType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cours_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Cours entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/new", name="cours_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Cours();
        $form   = $this->createForm(new CoursType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Cours entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="cours_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Cours')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cours entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Cours entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}/edit", name="cours_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Cours')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cours entity.');
        }

        $editForm = $this->createForm(new CoursType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Cours entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="cours_update")
     * @Method("PUT")
     * @Template("MspFrontendBundle:Cours:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Cours')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cours entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CoursType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cours_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Cours entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="cours_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MspFrontendBundle:Cours')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cours entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cours'));
    }

    /**
     * Creates a form to delete a Cours entity by id.
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
