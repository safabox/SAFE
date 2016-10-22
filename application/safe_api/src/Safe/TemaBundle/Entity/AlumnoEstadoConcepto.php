<?php

namespace Safe\TemaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AlumnoConceptoEstado
 *
 * @ORM\Table(name="alumno_concepto_estado")
 * @ORM\Entity(repositoryClass="Safe\TemaBundle\Repository\AlumnoEstadoConceptoRepository")
 */
class AlumnoEstadoConcepto
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Safe\AlumnoBundle\Entity\Alumno")
     * @ORM\JoinColumn(name="alumno_id", referencedColumnName="id", nullable=false)
     */
    private $alumno;

     /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Safe\TemaBundle\Entity\Concepto", inversedBy="estadosAlumnos")
     * @ORM\JoinColumn(name="concepto_id", referencedColumnName="id", nullable=false)
     */
    private $concepto;

    /**
     * @var bool
     *
     * @ORM\Column(name="aprobo", type="boolean")
     *
     */
    private $aprobo;


    public function __construct($alumno, $concepto, $aprobo = true)
    {
        $this->alumno = $alumno;
        $this->concepto = $concepto;
        $this->aprobo = $aprobo;
    } 
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set alumno
     *
     * @param \stdClass $alumno
     *
     * @return AlumnoConceptoEstado
     */
    public function setAlumno($alumno)
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * Get alumno
     *
     * @return \stdClass
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Set tema
     *
     * @param \stdClass $concepto
     *
     * @return AlumnoConceptoEstado
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get tema
     *
     * @return \stdClass
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set aprobo
     *
     * @param boolean $aprobo
     *
     * @return AlumnoConceptoEstado
     */
    public function setAprobo($aprobo)
    {
        $this->aprobo = $aprobo;

        return $this;
    }

    /**
     * Get aprobo
     *
     * @return bool
     */
    public function getAprobo()
    {
        return $this->aprobo;
    }
}

