<?php

namespace SIS\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SIS\AdminBundle\Entity\Estado
 *
 * @ORM\Table(name="estado")
 * @ORM\Entity(repositoryClass="SIS\AdminBundle\Entity\EstadoRepository")
 */
class Estado
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $estado
     *
     * @ORM\Column(name="estado", type="string", length=100)
     */
    private $estado;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set estado
     *
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    public function getEstate()
    {
        return $this->getEstado();
    }

	/**
     * @ORM\OneToMany(targetEntity="Localidad", mappedBy="estado")
     */
	private $localidad;

	public function __construct()
    {
		$this->localidad = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addLocalidad(\SIS\AdminBundle\Entity\Localidad $localidad)
    {
        $this->localidad []= $localidad;
    }

    public function getLocalidad()
    {
        return $this->localidad;
    }

	public function __toString() {
        return $this->getEstate();
    }

}