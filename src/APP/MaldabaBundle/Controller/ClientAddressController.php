<?php

namespace APP\MaldabaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use APP\MaldabaBundle\Entity\ClientAddress;
use APP\MaldabaBundle\Form\ClientAddressType;

/**
 * ClientAddress controller.
 *
 * @Route("/clientaddress")
 */
class ClientAddressController extends Controller
{

    /**
     * Lists all ClientAddress entities.
     *
     * @Route("/", name="clientaddress")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('APPMaldabaBundle:ClientAddress')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ClientAddress entity.
     *
     * @Route("/{clientId}", name="clientaddress_create")
     * @Method("POST")
     * @Template("APPMaldabaBundle:ClientAddress:new.html.twig")
     */
    public function createAction(Request $request, $clientId)
    {
        $entity = new ClientAddress();
        $form = $this->createCreateForm($entity, $clientId);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        
        $client = $em->getRepository('APPMaldabaBundle:Client')->find($clientId);

        if (!$client) {
            throw $this->createNotFoundException('Unable to find Client entity.');
        }

        if ($form->isValid()) {
            $entity->setClient($client);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('client_show', array('id' => $clientId)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ClientAddress entity.
     *
     * @param ClientAddress $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ClientAddress $entity, $clientId)
    {
        $form = $this->createForm(new ClientAddressType(), $entity, array(
            'action' => $this->generateUrl('clientaddress_create', array('clientId' => $clientId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ClientAddress entity.
     *
     * @Route("/new/{clientId}", name="clientaddress_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($clientId)
    {
        $entity = new ClientAddress();
        $form   = $this->createCreateForm($entity, $clientId);

        return array(
            'entity' => $entity,
            'clientId' => $clientId,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ClientAddress entity.
     *
     * @Route("/{id}", name="clientaddress_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('APPMaldabaBundle:ClientAddress')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ClientAddress entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ClientAddress entity.
     *
     * @Route("/{id}/edit", name="clientaddress_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('APPMaldabaBundle:ClientAddress')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ClientAddress entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a ClientAddress entity.
    *
    * @param ClientAddress $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ClientAddress $entity)
    {
        $form = $this->createForm(new ClientAddressType(), $entity, array(
            'action' => $this->generateUrl('clientaddress_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ClientAddress entity.
     *
     * @Route("/{id}", name="clientaddress_update")
     * @Method("PUT")
     * @Template("APPMaldabaBundle:ClientAddress:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('APPMaldabaBundle:ClientAddress')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ClientAddress entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('client_show', array('id' => $entity->getClient()->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ClientAddress entity.
     *
     * @Route("/{id}", name="clientaddress_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('APPMaldabaBundle:ClientAddress')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ClientAddress entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('client_show', array('id' => $entity->getClient()->getId())));
    }

    /**
     * Creates a form to delete a ClientAddress entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('clientaddress_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
