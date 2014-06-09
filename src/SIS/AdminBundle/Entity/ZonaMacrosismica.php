<?php

namespace SIS\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SIS\AdminBundle\Entity\ZonaMacrosismica
 *
 * @ORM\Table(name="zonamacrosismica")
 * @ORM\Entity(repositoryClass="SIS\AdminBundle\Entity\ZonaMacrosismicaRepository")
 */
class ZonaMacrosismica
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
     * @var string $zonaMacrosismica
     *
     * @ORM\Column(name="zonaMacrosismica", type="string", length=100)
     */
    private $zonaMacrosismica;

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
     * Set zonaMacrosismica
     *
     * @param string $zonaMacrosismica
     */
    public function setZonaMacrosismica($zonaMacrosismica)
    {
        $this->zonaMacrosismica = $zonaMacrosismica;
    }

    /**
     * Get zonaMacrosismica
     *
     * @return string 
     */
    public function getZonaMacrosismica()
    {
        return $this->zonaMacrosismica;
    }

	/**
     * @ORM\OneToMany(targetEntity="Sismo", mappedBy="zonaMacrosismica")
     */
	private $sismo;

	public function __construct()
    {
		$this->sismo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addSismo(\SIS\AdminBundle\Entity\Sismo $sismo)
    {
        $this->sismo []= $sismo;
    }

    public function getSismo()
    {
        return $this->sismo;
    }

	public function __toString() {
        return $this->getZonaMacrosismica();
    }

}