<?php

namespace SIS\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SIS\AdminBundle\Entity\Localidad
 *
 * @ORM\Table(name="localidad")
 * @ORM\Entity(repositoryClass="SIS\AdminBundle\Entity\LocalidadRepository")
 */
class Localidad
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
     * @var string $localidad
     *
     * @ORM\Column(name="localidad", type="string", length=100)
     */
    private $localidad;

    /**
     * @var string $nombreOficial
     *
     * @ORM\Column(name="nombreoficial", type="string", length=100)
     */
    private $nombreOficial;

    /**
     * @var decimal $latitud
     *
     * @ORM\Column(name="latitud", type="decimal",  scale=2)
     */
    private $latitud;

    /**
     * @var decimal $longitud
     *
     * @ORM\Column(name="longitud", type="decimal",  scale=2)
     */
    private $longitud;

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
     * Set localidad
     *
     * @param string $localidad
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;
    }

    /**
     * Get localidad
     *
     * @return string 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set nombreOficial
     *
     * @param string $nombreOficial
     */
    public function setNombreOficial($nombreOficial)
    {
        $this->nombreOficial = $nombreOficial;
    }

    /**
     * Get nombreOficial
     *
     * @return string 
     */
    public function getNombreOficial()
    {
        return $this->nombreOficial;
    }

    /**
     * Set latitud
     *
     * @param decimal $latitud
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;
    }

    /**
     * Get latitud
     *
     * @return decimal 
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * Set longitud
     *
     * @param decimal $longitud
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;
    }

    /**
     * Get longitud
     *
     * @return decimal 
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

	/**
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="localidad")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     * @return integer
     */
	private $estado;

	public function setEstado(\SIS\AdminBundle\Entity\Estado $estado)
	{
		$this->estado = $estado;
	}

    public function getEstado()
    {
        return $this->estado;
    }

	/**
     * @ORM\OneToMany(targetEntity="Temblor", mappedBy="localidad")
     */
	private $temblor;

	public function __construct()
    {
		$this->temblor = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addTemblor(\SIS\AdminBundle\Entity\Temblor $temblor)
    {
        $this->temblor []= $temblor;
    }

    public function getTemblor()
    {
        return $this->temblor;
    }

	public function __toString() {
        return $this->getLocalidad()." - ".$this->getNombreOficial();
    }
}