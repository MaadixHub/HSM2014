<?php

namespace SIS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SIS\AdminBundle\Entity\Localidad;
use SIS\AdminBundle\Form\LocalidadType;

/**
 * Localidad controller.
 *
 * @Route("/admin/localidad")
 */
class LocalidadController extends Controller
{
    /**
     * Lists all Localidad entities.
     *
     * @Route("/", name="admin_localidad")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SISAdminBundle:Localidad')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Localidad entity.
     *
     * @Route("/{id}/show", name="admin_localidad_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:Localidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Localidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Localidad entity.
     *
     * @Route("/new", name="admin_localidad_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Localidad();
        $form   = $this->createForm(new LocalidadType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Localidad entity.
     *
     * @Route("/create", name="admin_localidad_create")
     * @Method("post")
     * @Template("SISAdminBundle:Localidad:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Localidad();
        $request = $this->getRequest();
        $form    = $this->createForm(new LocalidadType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_localidad', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Localidad entity.
     *
     * @Route("/{id}/edit", name="admin_localidad_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:Localidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Localidad entity.');
        }

        $editForm = $this->createForm(new LocalidadType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Localidad entity.
     *
     * @Route("/{id}/update", name="admin_localidad_update")
     * @Method("post")
     * @Template("SISAdminBundle:Localidad:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:Localidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Localidad entity.');
        }

        $editForm   = $this->createForm(new LocalidadType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_localidad', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Localidad entity.
     *
     * @Route("/{id}/delete", name="admin_localidad_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('SISAdminBundle:Localidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Localidad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_localidad'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
