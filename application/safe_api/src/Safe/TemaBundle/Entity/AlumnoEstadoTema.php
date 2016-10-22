<?php

namespace Safe\TemaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AlumnoEstadoTema
 *
 * @ORM\Table(name="alumno_estado_tema")
 * @ORM\Entity(repositoryClass="Safe\TemaBundle\Repository\AlumnoEstadoTemaRepository")
 */
class AlumnoEstadoTema
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
     * @var bool
     *
     * @ORM\Column(name="aprobo", type="boolean")
     *
     */
    private $aprobo;

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
     * @ORM\ManyToOne(targetEntity="Safe\TemaBundle\Entity\Tema", inversedBy="estadosAlumnos")
     * @ORM\JoinColumn(name="tema_id", referencedColumnName="id", nullable=false)
     */
    private $tema;


    public function __construct($alumno, $tema, $aprobo = true)
    {
        $this->alumno = $alumno;
        $this->tema = $tema;
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

    function getAprobo() {
        return $this->aprobo;
    }

    function setAprobo($aprobo) {
        $this->aprobo = $aprobo;
    }

    
        /**
     * Set alumno
     *
     * @param \stdClass $alumno
     *
     * @return AlumnoEstadoTema
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
     * @param string $tema
     *
     * @return AlumnoEstadoTema
     */
    public function setTema($tema)
    {
        $this->tema = $tema;

        return $this;
    }

    /**
     * Get tema
     *
     * @return string
     */
    public function getTema()
    {
        return $this->tema;
    }
}

