<?php

namespace SIS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use SIS\AdminBundle\Entity\Temblor;
use SIS\AdminBundle\Entity\Localidad;
use SIS\AdminBundle\Entity\Sismo;
use SIS\AdminBundle\Form\TemblorType;

/**
 * Temblor controller.
 *
 * @Route("/admin/temblor")
 */
class TemblorController extends Controller
{
    /**
     * Lists all Temblor entities.
     *
     * @Route("/", name="admin_temblor")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SISAdminBundle:Temblor')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Temblor entity.
     *
     * @Route("/{id}/show", name="admin_temblor_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:Temblor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Temblor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Temblor entity.
     *
     * @Route("/new", name="admin_temblor_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Temblor();

		$idSismo = $this->get('request')->query->get('idSismo');
		if($idSismo!=NULL && $idSismo!=''){

		$em = $this->getDoctrine()->getEntityManager();
		$sismoEntity = $em->getRepository('SISAdminBundle:Sismo')->findById($idSismo);

		$sis;
		foreach($sismoEntity as $sismo){
			$sis = $sismo;
		}

        if (!$sismoEntity) {
            throw $this->createNotFoundException('Unable to find Sismo entity.');
        }

			$entity->setSismo($sis);
		}

        $form   = $this->createForm(new TemblorType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Temblor entity.
     *
     * @Route("/create", name="admin_temblor_create")
     * @Method("post")
     * @Template("SISAdminBundle:Temblor:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Temblor();
        $request = $this->getRequest();
        $form    = $this->createForm(new TemblorType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
			$entity->setPuntos(0);
            $em->persist($entity);
            $em->flush();


			$queryString = "SELECT p FROM SISAdminBundle:Temblor p WHERE p.sismo =:id_";
			$query = $em->createQuery($queryString);
			$query->setParameter('id_', $entity->getSismo()->getId());
			$result = $query->getResult();
			$total = count($result) - 1;

//			$entities = $em->getRepository('SISAdminBundle:Temblor')->findBySismo($entity->getSismo()->getId());
			$queryString = "SELECT p FROM SISAdminBundle:Temblor p WHERE p.sismo =:id_";
			$query = $em->createQuery($queryString);
			$query->setParameter('id_', $entity->getSismo()->getId());
			$entities = $query->getResult();

			foreach($entities as $temblor){
				$temblor->setPuntos($total);
				$em->persist($temblor);
				$em->flush();
			}


            return $this->redirect($this->generateUrl('admin_sismo', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Temblor entity.
     *
     * @Route("/{id}/edit", name="admin_temblor_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:Temblor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Temblor entity.');
        }

        $editForm = $this->createForm(new TemblorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Temblor entity.
     *
     * @Route("/{id}/update", name="admin_temblor_update")
     * @Method("post")
     * @Template("SISAdminBundle:Temblor:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SISAdminBundle:Temblor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Temblor entity.');
        }

        $editForm   = $this->createForm(new TemblorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_temblor', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Temblor entity.
     *
     * @Route("/{id}/delete", name="admin_temblor_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('SISAdminBundle:Temblor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Temblor entity.');
            }

            $em->remove($entity);
            $em->flush();

			$queryString = "SELECT p FROM SISAdminBundle:Temblor p WHERE p.sismo =:id_";
			$query = $em->createQuery($queryString);
			$query->setParameter('id_', $entity->getSismo()->getId());
			$result = $query->getResult();
			$total = count($result) - 1;

			$queryString = "SELECT p FROM SISAdminBundle:Temblor p WHERE p.sismo =:id_";
			$query = $em->createQuery($queryString);
			$query->setParameter('id_', $entity->getSismo()->getId());
			$entities = $query->getResult();

			foreach($entities as $temblor){
				$temblor->setPuntos($total);
				$em->persist($temblor);
				$em->flush();
			}
        }

        return $this->redirect($this->generateUrl('admin_temblor'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

	private function updatePuntos($sis_id)
	{
		$em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SISAdminBundle:Temblor')->findBySismo($sis_id);
	}

	/**
     * Displays a form to edit many existing Temblor entity.
     *
     * @Route("/{id}/editLocalidades", name="admin_temblor_editLocalidades")
     * @Template()
     */
    public function editLocalidadesAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

		$queryString = "SELECT p FROM SISAdminBundle:Temblor p WHERE p.sismo =:id_ AND p.localidad <> 736";

		$query = $em->createQuery($queryString);

		$query->setParameter('id_', $id);

		$entities = $query->getResult();

        if (!$entities) {
            throw $this->createNotFoundException('Unables to find Temblor entity.');
        }

		$arrayEditForm = array();
		
		foreach($entities as $entity){
			$editForm = $this->createForm(new TemblorType(), $entity);
			array_push($arrayEditForm, $editForm->createView());
		}

		return array(
            'entities'      => $entities,
            'edit_form'   => $arrayEditForm,
        );
    }

	/**
     * Edits an existing Temblor entity.
     *
     * @Route("updateLocaldiades", name="admin_temblor_update_localidades")
     * @Method("post")
     */
    public function updateLocaldiadesAction()
    {
		$request = $this->get('request');
		$id = $request->request->get('id');
		$loc = $request->request->get('loc');
		$inte = $request->request->get('inte');
		$com = $request->request->get('com');

        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('SISAdminBundle:Temblor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Temblor entity.');
        }

		$localidadEntity = $em->getRepository('SISAdminBundle:Localidad')->find($loc);
		$entity->setLocalidad($localidadEntity);
		$entity->setIntensidad($inte);
		$entity->setComentario($com);

        $em->persist($entity);
        $em->flush();

        return new Response("success");

    }

}
