<?php

namespace SIS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SIS\AdminBundle\Entity\ZonaMacrosismica;
use SIS\AdminBundle\Form\ZonaMacrosismicaType;

/**
 * ZonaMacrosismica controller.
 *
 * @Route("/admin/zonaMacrosismica")
 */
class ZonaMacrosismicaController extends Controller
{
    /**
     * Lists all ZonaMacrosismica entities.
     *
     * @Route("/", name="admin_zonaMacrosismica")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SISAdminBundle:ZonaMacrosismica')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a ZonaMacrosismica entity.
     *
     * @Route("/{id}/show", name="admin_zonaMacrosismica_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:ZonaMacrosismica')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ZonaMacrosismica entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new ZonaMacrosismica entity.
     *
     * @Route("/new", name="admin_zonaMacrosismica_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ZonaMacrosismica();
        $form   = $this->createForm(new ZonaMacrosismicaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new ZonaMacrosismica entity.
     *
     * @Route("/create", name="admin_zonaMacrosismica_create")
     * @Method("post")
     * @Template("SISAdminBundle:ZonaMacrosismica:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new ZonaMacrosismica();
        $request = $this->getRequest();
        $form    = $this->createForm(new ZonaMacrosismicaType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_zonaMacrosismica', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing ZonaMacrosismica entity.
     *
     * @Route("/{id}/edit", name="admin_zonaMacrosismica_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:ZonaMacrosismica')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ZonaMacrosismica entity.');
        }

        $editForm = $this->createForm(new ZonaMacrosismicaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ZonaMacrosismica entity.
     *
     * @Route("/{id}/update", name="admin_zonaMacrosismica_update")
     * @Method("post")
     * @Template("SISAdminBundle:ZonaMacrosismica:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:ZonaMacrosismica')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ZonaMacrosismica entity.');
        }

        $editForm   = $this->createForm(new ZonaMacrosismicaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_zonaMacrosismica', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ZonaMacrosismica entity.
     *
     * @Route("/{id}/delete", name="admin_zonaMacrosismica_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('SISAdminBundle:ZonaMacrosismica')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ZonaMacrosismica entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_zonaMacrosismica'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
