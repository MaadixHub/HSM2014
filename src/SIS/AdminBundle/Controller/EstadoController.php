<?php

namespace SIS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SIS\AdminBundle\Entity\Estado;
use SIS\AdminBundle\Form\EstadoType;

/**
 * Estado controller.
 *
 * @Route("/admin/estado")
 */
class EstadoController extends Controller
{
    /**
     * Lists all Estado entities.
     *
     * @Route("/", name="admin_estado")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SISAdminBundle:Estado')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Estado entity.
     *
     * @Route("/{id}/show", name="admin_estado_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:Estado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Estado entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Estado entity.
     *
     * @Route("/new", name="admin_estado_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Estado();
        $form   = $this->createForm(new EstadoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Estado entity.
     *
     * @Route("/create", name="admin_estado_create")
     * @Method("post")
     * @Template("SISAdminBundle:Estado:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Estado();
        $request = $this->getRequest();
        $form    = $this->createForm(new EstadoType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_estado_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Estado entity.
     *
     * @Route("/{id}/edit", name="admin_estado_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:Estado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Estado entity.');
        }

        $editForm = $this->createForm(new EstadoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Estado entity.
     *
     * @Route("/{id}/update", name="admin_estado_update")
     * @Method("post")
     * @Template("SISAdminBundle:Estado:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:Estado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Estado entity.');
        }

        $editForm   = $this->createForm(new EstadoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_estado_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Estado entity.
     *
     * @Route("/{id}/delete", name="admin_estado_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('SISAdminBundle:Estado')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Estado entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_estado'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
