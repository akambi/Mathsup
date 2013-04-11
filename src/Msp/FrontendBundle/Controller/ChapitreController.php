<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Msp\FrontendBundle\Entity\Chapitre;
use Msp\FrontendBundle\Form\ChapitreType;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Chapitre controller.
 *
 * @Route("/chapitre")
 */
class ChapitreController extends Controller
{
    /**
     * Lists all Chapitre entities.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/", name="chapitre")
     * @Method("GET")
     * @Template()
     */
    public function indexAction( $page )
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MspFrontendBundle:Chapitre');
        
        $total = $repository->getTotal();
        $nb_par_page = $this->container->getParameter('chapitre');
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
            'nb_pages' => $nb_pages,
        );
    }

    /**
     * Creates a new Chapitre entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/", name="chapitre_create")
     * @Method("POST")
     * @Template("MspFrontendBundle:Chapitre:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Chapitre();
        $form = $this->createForm(new ChapitreType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('chapitre_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Chapitre entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/new", name="chapitre_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Chapitre();
        $form   = $this->createForm(new ChapitreType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Chapitre entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="chapitre_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Chapitre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chapitre entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Chapitre entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}/edit", name="chapitre_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Chapitre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chapitre entity.');
        }

        $editForm = $this->createForm(new ChapitreType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Chapitre entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="chapitre_update")
     * @Method("PUT")
     * @Template("MspFrontendBundle:Chapitre:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Chapitre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chapitre entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ChapitreType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('chapitre_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Chapitre entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="chapitre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MspFrontendBundle:Chapitre')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Chapitre entity.');
            }
            
            foreach ( $entity->getExcerciceCorriges() as $exerciceCorrige )
            {
                $em->remove($exerciceCorrige);
            }
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('chapitre'));
    }

    /**
     * Creates a form to delete a Chapitre entity by id.
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
