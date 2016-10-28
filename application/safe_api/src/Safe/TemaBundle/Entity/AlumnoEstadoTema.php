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
     * @ORM\Column(name="aprobado", type="boolean")
     *
     */
    private $aprobado;

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


    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=100)
     *
     */
    private $estado;
    
    public function __construct($alumno, $tema, $aprobado = true, $estado = 'FINALIZADO')
    {
        $this->alumno = $alumno;
        $this->tema = $tema;
        $this->aprobado = $aprobado;
        $this->estado = $estado;
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

    function isAprobado() {
        return $this->aprobado;
    }

    function setAprobado($aprobado) {
        $this->aprobado = $aprobado;
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
    
    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }


}

