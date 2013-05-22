<?php

namespace Msp\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Msp\FrontendBundle\Entity\Conference;
use Msp\FrontendBundle\Form\ConferenceType;

use JMS\SecurityExtraBundle\Annotation\Secure;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
/**
 * Conference controller.
 *
 * @Route("/msp_professeur_conference")
 */
class ConferenceController extends Controller
{
    /**
     * Es-il autorisé à faire une action
     */
    public function isAuthorised($id){
    //  Si c'est l'administrateur il a accès
        if( $this->get('security.context')->isGranted('ROLE_ADMIN') ):
            return true;
        endif;
    //  Si les identifiants sont différents alors il n'a pas accès
        if( $this->container->get('security.context')->getToken()->getUser()->getId() != $id ):
            return false;
        endif;
        
        return true;
    }
    
    /**
     * Lists all Conference entities.
     * @Secure(roles="ROLE_PROFESSEUR")
     * @Route("/", name="msp_professeur_conference")
     * @Method("GET")
     * @Template()
     */
    public function indexAction( $page )
    {
    //  On récupère l'utilisateur courant
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();        
        $repository = $em->getRepository('MspFrontendBundle:Conference');
        
        $total = $repository->getTotal();
        $nb_par_page = $this->container->getParameter('conference');
        $nb_pages = (ceil($total/$nb_par_page))? ceil($total/$nb_par_page): 1;    
        $offset = ($page-1) * $nb_par_page;
        
        if( $page < 1 OR $page > $nb_pages )
        {
            throw $this->createNotFoundException('Page inexistante (page = '.$page.')');
        }
        
        if( $this->get('security.context')->isGranted('ROLE_ADMIN') ):
            $entities = $repository->findBy(
                array(), // Pas de critère
                array(), // On tri par date décroissante
                $nb_par_page, // On sélectionne $nb_articles_page articles
                $offset // A partir du $offset ième
            );
        else:
            $entities = $repository->findBy(
                array("user" => $user->getId() ), // Pas de critère
                array(), // On tri par date décroissante
                $nb_par_page, // On sélectionne $nb_articles_page articles
                $offset // A partir du $offset ième
            );
        endif;

        return array(
            'entities' => $entities,            
            'page' => $page,
            'nb_pages' => $nb_pages,
        );
    }

    /**
     * Creates a new Conference entity.
     * @Secure(roles="ROLE_PROFESSEUR")
     * @Route("/", name="msp_professeur_conference_create")
     * @Method("POST")
     * @Template("MspFrontendBundle:Conference:new.html.twig")
     */
    public function createAction(Request $request)
    {
        //  On récupère l'utilisateur courant
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $entity  = new Conference();
        $form = $this->createForm(new ConferenceType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setMeetingVersion( time() );
            $entity->setMeetingID( sha1($entity->getMeetingName().strval($entity->getMeetingVersion())) );
            $entity->setUser($user);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('msp_professeur_conference_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Conference entity.
     * @Secure(roles="ROLE_PROFESSEUR")
     * @Route("/new", name="msp_professeur_conference_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Conference();
        $form   = $this->createForm(new ConferenceType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Conference entity.
     * @Secure(roles="ROLE_PROFESSEUR")
     * @Route("/{id}", name="msp_professeur_conference_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction( $id )
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Conference')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conference entity.');
        }
        
        if( ! $this->isAuthorised( $entity->getUser()->getId() ) )
        {        
            throw new AccessDeniedHttpException('Accès limité aux propriétaires');
        }
        
        $deleteForm = $this->createDeleteForm( $id );

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Conference entity.
     * @Secure(roles="ROLE_PROFESSEUR")
     * @Route("/{id}/edit", name="msp_professeur_conference_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Conference')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conference entity.');
        }
        
        if( ! $this->isAuthorised( $entity->getUser()->getId() ) )
        {        
            throw new AccessDeniedHttpException('Accès limité aux propriétaires');
        }
        
        $editForm = $this->createForm(new ConferenceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Conference entity.
     * @Secure(roles="ROLE_PROFESSEUR")
     * @Route("/{id}", name="msp_professeur_conference_update")
     * @Method("PUT")
     * @Template("MspFrontendBundle:Conference:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MspFrontendBundle:Conference')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conference entity.');
        }
        
        if( ! $this->isAuthorised( $entity->getUser()->getId() ) )
        {        
            throw new AccessDeniedHttpException('Accès limité aux propriétaires');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ConferenceType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('msp_professeur_conference_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Conference entity.
     * @Secure(roles="ROLE_PROFESSEUR")
     * @Route("/{id}", name="msp_professeur_conference_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MspFrontendBundle:Conference')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Conference entity.');
            }
            
            if( ! $this->isAuthorised( $entity->getUser()->getId() ) )
            {        
                throw new AccessDeniedHttpException('Accès limité aux propriétaires');
            }
            
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('msp_professeur_conference'));
    }

    /**
     * Creates a form to delete a Conference entity by id.
     * @Secure(roles="ROLE_PROFESSEUR")
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
