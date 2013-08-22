<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Msp\UserBundle\Entity\User;
use Msp\FrontendBundle\Entity\Coupon;
use Msp\FrontendBundle\Form\EleveType As UserType;
use Msp\FrontendBundle\Form\CouponType;

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
    public function indexAction( $departement, $classe )
    {
        $em = $this->getDoctrine()->getManager();
    //  Les autres options de tri
        $option = array();
    //  ici on prend en compte le tri par departement
        if( $departement ):
            $option["departement"] = $em->getRepository('MspFrontendBundle:Departement')->find( $departement );
        endif;
        
        
     //  ici on prend en compte le tri par classe
        if( $classe ):
            $option["classe"] = $em->getRepository('MspFrontendBundle:Classe')->find( $classe );
        endif;
        
    //  On récupèle la liste des élèves
        if( !empty( $option ) ):            
            $entities = $em->getRepository('MspUserBundle:User')->getUserByRoleAndCriteria("ROLE_ELEVE", $option);
        else:
            $entities = $em->getRepository('MspUserBundle:User')->getUserByRoleAndCriteria("ROLE_ELEVE");
        endif;
        
        $niveaux = array();
        foreach($entities as $entity):
            $classe = $entity->getClasse();
            $niveaux[] = $classe->getNiveau();
        endforeach;
        
        
        return array(
            'entities' => $entities,
            'niveaux'  => $niveaux,
            'option' => $option,            
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
     * @Template("MspFrontendBundle:Eleve:edit.html.twig")
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
        //  On prend en compte les parents
            $parent = $entity->getUserFamily();
            if ($parent)
            {
                $parent->setUser($entity);
                $em->persist($parent);
            }
            
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
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function eleveTicketAction( $id )
    {
        $em = $this->getDoctrine()->getManager();
    //  On récupère l'utilisateur
        $user = $em->getRepository('MspUserBundle:User')->find($id);      
    //  On définit ici les repository             
        $repository = $em->getRepository('MspFrontendBundle:Coupon');        
    //  On récupère le total des coupons de l'utilisateur et ceux restants
        $ticket_total = $repository->getAllForUser( $user );
        $ticket_utiliser = $repository->getAllIsUseForUser( $user );
    //  On récupère les tickets restants
        $entities = $repository->getAllIsNotUseForUser( $user );        
        
        return $this->render('MspFrontendBundle:Eleve:eleve_ticket.html.twig', 
                array( "ticket_total" => $ticket_total, "ticket_utiliser" => $ticket_utiliser, 'entities' => $entities, 'user' => $user ) );
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function eleveTicketAjouterAction( $id )
    {
        $em = $this->getDoctrine()->getManager();
    //  On récupère l'utilisateur
        $user = $em->getRepository('MspUserBundle:User')->find($id);         
    //  on crée le formulaire
        $entity = new Coupon();
        $entity->setUser($user);
        $form   = $this->createForm(new CouponType(), $entity);
    //  on contrôle le formulaire et on enregistre
        $request = $this->getRequest();        
        
        if( $request->getMethod() == 'POST' ):
            $form->bind($request);            
            
            if ( $form->isValid() ) {
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('eleve_ticket_show', array( 'id' => $entity->getId(), 'user_id' => $user->getId() ) ) );
            }
        endif;
        
        return  $this->render('MspFrontendBundle:Eleve:eleve_ticket_ajouter.html.twig', 
                array( 'entity' => $entity, 'form'   => $form->createView(), 'user' => $user) );
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function eleveTicketShowAction( $id, $user_id )
    {
    //  on récupère le coupon
        $em = $this->getDoctrine()->getManager();
    //  On récupère l'utilisateur
        $user = $em->getRepository('MspUserBundle:User')->find($user_id); 
        
        $entity = $em->getRepository('MspFrontendBundle:Coupon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Coupon entity.');
        }
                       
        return  $this->render('MspFrontendBundle:Eleve:eleve_ticket_show.html.twig', 
                array( 'entity' => $entity, 'user' => $user ) );
    }
    
}
