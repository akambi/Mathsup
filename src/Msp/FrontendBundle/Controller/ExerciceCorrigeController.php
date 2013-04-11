<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Msp\FrontendBundle\Entity\ExerciceCorrige;
use Msp\FrontendBundle\Form\ExerciceCorrigeType;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * ExerciceCorrige controller.
 *
 * @Route("/exercicecorrige")
 */
class ExerciceCorrigeController extends Controller
{
    /**
     * Lists all ExerciceCorrige entities.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/", name="exercicecorrige")
     * @Method("GET")
     * @Template()
     */
    public function indexAction( $page )
    {
        $em = $this->getDoctrine()->getManager();        
        $repository = $em->getRepository('MspFrontendBundle:ExerciceCorrige');
        
        $request = $this->getRequest();
        $chapitre_id = $request->query->get("chapitre");                
        if($chapitre_id):
            $chapitre = $em->getRepository('MspFrontendBundle:Chapitre')->find($chapitre_id);
            $entities = $chapitre->getExcerciceCorriges();
        else:
            $entities = $repository->findAll();
        endif;  
        
        $total = count($entities);
        $nb_par_page = $this->container->getParameter('excerccice_corrige');
        $nb_pages = (ceil($total/$nb_par_page))? ceil($total/$nb_par_page): 1;    
        $offset = ($page-1) * $nb_par_page;
        
        if( $page < 1 OR $page > $nb_pages )
        {
            throw $this->createNotFoundException('Page inexistante (page = '.$page.')');
        }
        
        $entities = $repository->findBy(
            array( "chapitre" => $chapitre_id ), // Pas de critère
            array(), // On tri par date décroissante
            $nb_par_page, // On sélectionne $nb_articles_page articles
            $offset // A partir du $offset ième
        );        

        return array(
            'entities' => $entities,
            'page' => $page,
            'nb_pages' => $nb_pages,
            'chapitre' => $chapitre,
        );
    }

    /**
     * Creates a new ExerciceCorrige entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/", name="exercicecorrige_create")
     * @Method("POST")
     * @Template("MspFrontendBundle:ExerciceCorrige:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $chapitre_id = $request->query->get("chapitre");
        
        $entity  = new ExerciceCorrige();
        $form = $this->createForm(new ExerciceCorrigeType(), $entity);
        $form->bind($request);
        
        if ($form->isValid()) {                
            $em = $this->getDoctrine()->getManager();          
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('exercicecorrige_show', array('id' => $entity->getId(), 'chapitre' => $chapitre_id)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'chapitre_id' => $chapitre_id,
        );
    }

    /**
     * Displays a form to create a new ExerciceCorrige entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/new", name="exercicecorrige_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $request = $this->getRequest();        
        $chapitre_id = $request->query->get("chapitre");
        
        $em = $this->getDoctrine()->getManager();
        if($chapitre_id):
            $chapitre = $em->getRepository('MspFrontendBundle:Chapitre')->find($chapitre_id);
            $entity = new ExerciceCorrige();
            $entity->setChapitre($chapitre);
        else:
            $entity = new ExerciceCorrige();
        endif;
                
        $form   = $this->createForm(new ExerciceCorrigeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'chapitre_id' => $chapitre_id,
        );
    }

    /**
     * Finds and displays a ExerciceCorrige entity.
     * @Secure(roles="ROLE_ADMIN")
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
        
        $request = $this->getRequest();        
        $chapitre_id = $request->query->get("chapitre");
        
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'chapitre_id' => $chapitre_id,
        );
    }

    /**
     * Displays a form to edit an existing ExerciceCorrige entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}/edit", name="exercicecorrige_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $request = $this->getRequest();        
        $chapitre_id = $request->query->get("chapitre");
        
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
            'chapitre_id' => $chapitre_id,
        );
    }

    /**
     * Edits an existing ExerciceCorrige entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="exercicecorrige_update")
     * @Method("PUT")
     * @Template("MspFrontendBundle:ExerciceCorrige:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $chapitre_id = $request->query->get("chapitre");
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:ExerciceCorrige')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExerciceCorrige entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ExerciceCorrigeType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {                       
            //$entity->preUpload();            
            $em->persist($entity);
            //$entity->upload();
            $em->flush();

            //return $this->redirect($this->generateUrl('exercicecorrige_edit', array('id' => $id, 'chapitre' => $chapitre_id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'chapitre_id' => $chapitre_id,
        );
    }

    /**
     * Deletes a ExerciceCorrige entity.
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="exercicecorrige_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $chapitre_id = $request->query->get("chapitre");
        
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

        return $this->redirect($this->generateUrl('exercicecorrige', array( 'chapitre' => $chapitre_id )));
    }

    /**
     * Creates a form to delete a ExerciceCorrige entity by id.
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
