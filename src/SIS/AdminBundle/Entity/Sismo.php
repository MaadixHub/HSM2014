<?php

namespace SIS\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SIS\AdminBundle\Entity\Sismo
 *
 * @ORM\Table(name="sismo")
 * @ORM\Entity(repositoryClass="SIS\AdminBundle\Entity\SismoRepository")
 */
class Sismo
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
     * @var string $sismo
     *
     * @ORM\Column(name="sismo", type="string", length=300, nullable=true)
     */
    private $sismo;

    /**
     * @var string $anio
     *
     * @ORM\Column(name="anio", type="integer", nullable=true)
     */
    private $anio;

    /**
     * @var string $mes
     *
     * @ORM\Column(name="mes", type="integer", nullable=true)
     */
    private $mes;

    /**
     * @var string $dia
     *
     * @ORM\Column(name="dia", type="integer", nullable=true)
     */
    private $dia;

    /**
     * @var string $hora
     *
     * @ORM\Column(name="hora", type="integer", nullable=true)
     */
    private $hora;

    /**
     * @var string $minuto
     *
     * @ORM\Column(name="minuto", type="integer", nullable=true)
     */
    private $minuto;

	/**
     * @var string $segundo
     *
     * @ORM\Column(name="segundo", type="integer", nullable=true)
     */
    private $segundo;

    /**
     * @var string $intensidadMaxima
     *
     * @ORM\Column(name="intensidadMaxima", type="string", length=10, nullable=true)
     */
    private $intensidadMaxima;

    /**
     * @var string $intensidadEpicentral
     *
     * @ORM\Column(name="intensidadEpicentral", type="string", length=100, nullable=true)
     */
    private $intensidadEpicentral;

    /**
     * @var string $magnitudEstimada
     *
     * @ORM\Column(name="magnitudEstimada", type="string", length=100, nullable=true)
     */
    private $magnitudEstimada;

	/**
     * @var string $fenomenosAsociados
     *
     * @ORM\Column(name="fenomenosAsociados", type="string", length=5000, nullable=true)
     */
    private $fenomenosAsociados;

	/**
     * @var string $resumenDanos
     *
     * @ORM\Column(name="resumenDanos", type="string", length=5000, nullable=true)
     */
    private $resumenDanos;

	/**
     * @var string $citaRepresentativa
     *
     * @ORM\Column(name="citaRepresentativa", type="string", length=5000, nullable=true)
     */
    private $citaRepresentativa;

	/**
     * @var string $bibliografia
     *
     * @ORM\Column(name="bibliografia", type="string", length=2000, nullable=true)
     */
    private $bibliografia;

	/**
     * @var string $interpretacion
     *
     * @ORM\Column(name="interpretacion", type="string", length=5000, nullable=true)
     */
    private $interpretacion;

	/**
     * @var string $citaTextual
     *
     * @ORM\Column(name="citaTextual", type="string", length=5000, nullable=true)
     */
    private $citaTextual;
	
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
     * Set sismo
     *
     * @param string $sismo
     */
    public function setSismo($sismo)
    {
        $this->sismo = $sismo;
    }

    /**
     * Get sismo
     *
     * @return string 
     */
    public function getSismo()
    {
        return $this->sismo;
    }

    /**
     * Set anio
     *
     * @param integer $anio
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;
    }

    /**
     * Get anio
     *
     * @return anio
     */
    public function getAnio()
    {
        return $this->anio;
    }

	/**
     * Set mes
     *
     * @param integer $mes
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
    }

    /**
     * Get mes
     *
     * @return mes
     */
    public function getMes()
    {
        return $this->mes;
    }

	/**
     * Set dia
     *
     * @param integer $dia
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
    }

    /**
     * Get dia
     *
     * @return dia
     */
    public function getDia()
    {
        return $this->dia;
    }

	/**
     * Set hora
     *
     * @param integer $hora
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    /**
     * Get hora
     *
     * @return hora
     */
    public function getHora()
    {
        return $this->hora;
    }

	/**
     * Set minuto
     *
     * @param integer $minuto
     */
    public function setMinuto($minuto)
    {
        $this->minuto = $minuto;
    }

    /**
     * Get minuto
     *
     * @return minuto
     */
    public function getMinuto()
    {
        return $this->minuto;
    }

	/**
     * Set segundo
     *
     * @param integer $segundo
     */
    public function setSegundo($segundo)
    {
        $this->segundo = $segundo;
    }

    /**
     * Get segundo
     *
     * @return segundo
     */
    public function getSegundo()
    {
        return $this->segundo;
    }



    /**
     * Set intensidadMaxima
     *
     * @param string $intensidadMaxima
     */
    public function setIntensidadMaxima($intensidadMaxima)
    {
        $this->intensidadMaxima = $intensidadMaxima;
    }

    /**
     * Get intensidadMaxima
     *
     * @return string 
     */
    public function getIntensidadMaxima()
    {
        return $this->intensidadMaxima;
    }

	/**
     * Set intensidadEpicentral
     *
     * @param string $intensidadEpicentral
     */
    public function setIntensidadEpicentral($intensidadEpicentral)
    {
        $this->intensidadEpicentral = $intensidadEpicentral;
    }

    /**
     * Get intensidadEpicentral
     *
     * @return string 
     */
    public function getIntensidadEpicentral()
    {
        return $this->intensidadEpicentral;
    }

	/**
     * Set magnitudEstimada
     *
     * @param string $magnitudEstimada
     */
    public function setMagnitudEstimada($magnitudEstimada)
    {
        $this->magnitudEstimada = $magnitudEstimada;
    }

    /**
     * Get magnitudEstimada
     *
     * @return string 
     */
    public function getMagnitudEstimada()
    {
        return $this->magnitudEstimada;
    }

	/**
     * Set fenomenosAsociados
     *
     * @param string $fenomenosAsociados
     */
    public function setFenomenosAsociados($fenomenosAsociados)
    {
        $this->fenomenosAsociados = $fenomenosAsociados;
    }

    /**
     * Get fenomenosAsociados
     *
     * @return string 
     */
    public function getFenomenosAsociados()
    {
        return $this->fenomenosAsociados;
    }

	/**
     * Set resumenDanos
     *
     * @param string $resumenDanos
     */
    public function setResumenDanos($resumenDanos)
    {
        $this->resumenDanos = $resumenDanos;
    }

    /**
     * Get resumenDanos
     *
     * @return string 
     */
    public function getResumenDanos()
    {
        return $this->resumenDanos;
    }

	/**
     * Set citaRepresentativa
     *
     * @param string $citaRepresentativa
     */
    public function setCitaRepresentativa($citaRepresentativa)
    {
        $this->citaRepresentativa = $citaRepresentativa;
    }

    /**
     * Get citaRepresentativa
     *
     * @return string 
     */
    public function getCitaRepresentativa()
    {
        return $this->citaRepresentativa;
    }

	/**
     * Set bibliografia
     *
     * @param string $bibliografia
     */
    public function setBibliografia($bibliografia)
    {
        $this->bibliografia = $bibliografia;
    }

    /**
     * Get bibliografia
     *
     * @return string 
     */
    public function getBibliografia()
    {
        return $this->bibliografia;
    }

	/**
     * Set interpretacion
     *
     * @param string $interpretacion
     */
    public function setInterpretacion($interpretacion)
    {
        $this->interpretacion = $interpretacion;
    }

    /**
     * Get interpretacion
     *
     * @return string 
     */
    public function getInterpretacion()
    {
        return $this->interpretacion;
    }

	/**
     * Set citaTextual
     *
     * @param string $citaTextual
     */
    public function setCitaTextual($citaTextual)
    {
        $this->citaTextual = $citaTextual;
    }

    /**
     * Get citaTextual
     *
     * @return string 
     */
    public function getCitaTextual()
    {
        return $this->citaTextual;
    }

	/**
     * @ORM\ManyToOne(targetEntity="ZonaMacrosismica", inversedBy="sismo")
     * @ORM\JoinColumn(name="zonaMacrosismica_id", referencedColumnName="id")
     * @return integer
     */
	private $zonaMacrosismica;

	public function setZonaMacrosismica(\SIS\AdminBundle\Entity\ZonaMacrosismica $zonaMacrosismica)
	{
		$this->zonaMacrosismica = $zonaMacrosismica;
	}

    public function getZonaMacrosismica()
    {
        return $this->zonaMacrosismica;
    }

	/**
     * @ORM\OneToMany(targetEntity="Temblor", mappedBy="sismo")
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

	public function __toString()
	{
		$string = ($this->getSismo() != NULL) ? $this->getId()." - ".$this->getAnio()."/".$this->getMes()."/".$this->getDia() : $this->getId()." - ".$this->getAnio()."/".$this->getMes()."/".$this->getDia();

        return $string;
    }

}