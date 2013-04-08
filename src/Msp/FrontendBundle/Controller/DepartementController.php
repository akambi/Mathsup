<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Msp\FrontendBundle\Entity\Departement;
use Msp\FrontendBundle\Form\DepartementType;

/**
 * Departement controller.
 *
 * @Route("/departement")
 */
class DepartementController extends Controller
{
    /**
     * Lists all Departement entities.
     *
     * @Route("/", name="departement")
     * @Method("GET")
     * @Template()
     */
    public function indexAction( $page )
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MspFrontendBundle:Departement');
        
        $total = $repository->getTotal();
        $nb_par_page = 10;        
        $nb_pages = (ceil($total/$nb_par_page))? ceil($total/$nb_par_page): 1;    
        $offset = ($page-1) * $nb_par_page;
        if( $page < 1 OR $page > $nb_pages )
        {
            throw $this->createNotFoundException('Page inexistante (page = '.$page.')');
        }
        
        $entities = $repository->findBy(
            array(), // Pas de critère
            array(), // On tri par date décroissante
            $nb_par_page, // On sélectionne $nb_articles_page articles
            $offset // A partir du $offset ième
        );
        

        return array(
            'entities' => $entities,
            'page' => $page,
            'nb_pages' => $nb_pages
        );
    }

    /**
     * Creates a new Departement entity.
     *
     * @Route("/", name="departement_create")
     * @Method("POST")
     * @Template("MspFrontendBundle:Departement:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Departement();
        $form = $this->createForm(new DepartementType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('departement_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Departement entity.
     *
     * @Route("/new", name="departement_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Departement();
        $form   = $this->createForm(new DepartementType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Departement entity.
     *
     * @Route("/{id}", name="departement_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Departement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Departement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Departement entity.
     *
     * @Route("/{id}/edit", name="departement_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Departement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Departement entity.');
        }

        $editForm = $this->createForm(new DepartementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Departement entity.
     *
     * @Route("/{id}", name="departement_update")
     * @Method("PUT")
     * @Template("MspFrontendBundle:Departement:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Departement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Departement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new DepartementType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('departement_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Departement entity.
     *
     * @Route("/{id}", name="departement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MspFrontendBundle:Departement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Departement entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('departement'));
    }

    /**
     * Creates a form to delete a Departement entity by id.
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
