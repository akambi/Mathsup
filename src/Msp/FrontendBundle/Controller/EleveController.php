<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Msp\UserBundle\Entity\User;
use Msp\FrontendBundle\Form\EleveType As UserType;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * 
 * User controller.
 *
 * @Route("/eleve")
 */
class EleveController extends Controller
{
    /**
     * @Secure(roles="ROLE_ADMIN")
     * Lists all User entities.
     *
     * @Route("/", name="eleve")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MspUserBundle:User')->getUserByRole("ROLE_ELEVE");
        $niveaux = array();
        foreach($entities as $entity):
            $classe = $entity->getClasse();
            $niveaux[] = $classe->getNiveau();
        endforeach;
        
        
        return array(
            'entities' => $entities,
            'niveaux'  => $niveaux,
        );
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="eleve_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $classe = $entity->getClasse();
        $niveau = $classe->getNiveau();
        
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'niveau'  => $niveau,
        );
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="eleve_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createForm(new UserType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     * Edits an existing User entity.
     * 
     * @Route("/{id}", name="eleve_update")
     * @Method("PUT")
     * @Template("MspUserBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UserType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('eleve_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     * Deletes a User entity.
     *
     * @Route("/{id}", name="eleve_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MspUserBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('eleve'));
    }

    /**
     * Creates a form to delete a User entity by id.
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
