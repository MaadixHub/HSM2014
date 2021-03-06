<?php

namespace SIS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SIS\AdminBundle\Entity\Sismo;
use SIS\AdminBundle\Entity\Temblor;
use SIS\AdminBundle\Entity\Localidad;
use SIS\AdminBundle\Form\SismoType;

/**
 * Sismo controller.
 *
 * @Route("/admin/sismo")
 */
class SismoController extends Controller
{
    /**
     * Lists all Sismo entities.
     *
     * @Route("/", name="admin_sismo")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SISAdminBundle:Sismo')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Sismo entity.
     *
     * @Route("/{id}/show", name="admin_sismo_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:Sismo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sismo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Sismo entity.
     *
     * @Route("/new", name="admin_sismo_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Sismo();
        $form   = $this->createForm(new SismoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Sismo entity.
     *
     * @Route("/create", name="admin_sismo_create")
     * @Method("post")
     * @Template("SISAdminBundle:Sismo:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Sismo();
        $request = $this->getRequest();
        $form    = $this->createForm(new SismoType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

		$entity = $em->getRepository('SISAdminBundle:Sismo')->find($entity->getId());
		$entityT  = new Temblor();
		$entityT->setPuntos(0);
		$entityT->setSismo($entity);
		$localidad  = $em->getRepository('SISAdminBundle:Localidad')->find(736);
		$entityT->setLocalidad($localidad);
        $emT = $this->getDoctrine()->getEntityManager();
        $emT->persist($entityT);
        $emT->flush();

            return $this->redirect($this->generateUrl('admin_sismo', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Sismo entity.
     *
     * @Route("/{id}/edit", name="admin_sismo_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:Sismo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sismo entity.');
        }

        $editForm = $this->createForm(new SismoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Sismo entity.
     *
     * @Route("/{id}/update", name="admin_sismo_update")
     * @Method("post")
     * @Template("SISAdminBundle:Sismo:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:Sismo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sismo entity.');
        }

        $editForm   = $this->createForm(new SismoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_sismo', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Sismo entity.
     *
     * @Route("/{id}/delete", name="admin_sismo_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('SISAdminBundle:Sismo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Sismo entity.');
            }

			$queryString = "SELECT p FROM SISAdminBundle:Temblor p WHERE p.sismo =:id_";
			$query = $em->createQuery($queryString);
			$query->setParameter('id_', $entity->getId());
			$result = $query->getResult();
			$total = count($result);

			if($total == 1){
				$queryString = "SELECT p FROM SISAdminBundle:Temblor p WHERE p.sismo =:id_";
				$query = $em->createQuery($queryString);
				$query->setParameter('id_', $entity->getId());
				$entities = $query->getResult();
				foreach($entities as $temblor){
					$em->remove($temblor);
					$em->flush();
				}
			}

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_sismo'));
    }

    /**
     * Finds and displays a Sismo's localidades.
     *
     * @Route("/{id}/localidades", name="admin_sismo_localidades")
     * @Template()
     */
    public function localidadesAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $sismoEntity = $em->getRepository('SISAdminBundle:Sismo')->find($id);

		$queryString = "SELECT p FROM SISAdminBundle:Temblor p WHERE p.sismo =:id_";
		$query = $em->createQuery($queryString);
		$query->setParameter('id_', $id);
		$temblorEntities = $query->getResult();

        if (!$sismoEntity) {
            throw $this->createNotFoundException('Unable to find Sismo entity.');
        }

        return array('sismoEntity' => $sismoEntity, 'temblorEntities' => $temblorEntities,);
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
