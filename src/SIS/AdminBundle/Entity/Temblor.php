<?php

namespace SIS\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SIS\AdminBundle\Entity\Temblor
 *
 * @ORM\Table(name="temblor")
 * @ORM\Entity(repositoryClass="SIS\AdminBundle\Entity\TemblorRepository")
 */
class Temblor
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
     * @var integer $puntos
     *
     * @ORM\Column(name="puntos", type="integer")
     */
    private $puntos;

    /**
     * @var integer $intensidad
     *
     * @ORM\Column(name="intensidad", type="integer", nullable=true)
     */
    private $intensidad;

    /**
     * @var string $comentario
     *
     * @ORM\Column(name="comentario", type="string", length=3000, nullable=true)
     */
    private $comentario;

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
     * Set puntos
     *
     * @param integer $puntos
     */
    public function setPuntos($puntos)
    {
        $this->puntos = $puntos;
    }

    /**
     * Get puntos
     *
     * @return integer 
     */
    public function getPuntos()
    {
        return $this->puntos;
    }

    /**
     * Set intensidad
     *
     * @param integer $intensidad
     */
    public function setIntensidad($intensidad)
    {
        $this->intensidad = $intensidad;
    }

    /**
     * Get intensidad
     *
     * @return integer 
     */
    public function getIntensidad()
    {
        return $this->intensidad;
    }

	/**
     * Set comentario
     *
     * @param string $comentario
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
    }

	/**
     * @ORM\ManyToOne(targetEntity="Sismo", inversedBy="temblor")
     * @ORM\JoinColumn(name="sismo_id", referencedColumnName="id")
     * @return integer
     */
	private $sismo;

	public function setSismo(\SIS\AdminBundle\Entity\Sismo $sismo)
	{
		$this->sismo = $sismo;
	}

    public function getSismo()
    {
        return $this->sismo;
    }

	/**
     * @ORM\ManyToOne(targetEntity="Localidad", inversedBy="temblor")
     * @ORM\JoinColumn(name="localidad_id", referencedColumnName="id")
     * @return integer
     */
	private $localidad;

	public function setLocalidad(\SIS\AdminBundle\Entity\Localidad $localidad)
	{
		$this->localidad = $localidad;
	}

    public function getLocalidad()
    {
        return $this->localidad;
    }

	public function __toString()
	{
        return $this->getId()."";
    }

}