<?php

namespace Safe\TemaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AlumnoEstadoCurso
 *
 * @ORM\Table(name="alumno_estado_curso")
 * @ORM\Entity(repositoryClass="Safe\TemaBundle\Repository\AlumnoEstadoCursoRepository")
 */
class AlumnoEstadoCurso
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
     * @ORM\ManyToOne(targetEntity="Safe\CursoBundle\Entity\Curso", inversedBy="estadosAlumnos")
     * @ORM\JoinColumn(name="curso_id", referencedColumnName="id", nullable=false)
     */
    private $curso;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=100)
     */
    private $estado;

    public function __construct($alumno, $curso, $aprobado = true, $estado='FINALIZADO')
    {
        $this->alumno = $alumno;
        $this->curso = $curso;
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

    /**
     * Set aprobado
     *
     * @param boolean $aprobado
     *
     * @return AlumnoEstadoCurso
     */
    public function setAprobado($aprobado)
    {
        $this->aprobado = $aprobado;

        return $this;
    }

    /**
     * Get aprobado
     *
     * @return bool
     */
    public function getAprobado()
    {
        return $this->aprobado;
    }

    /**
     * Set alumno
     *
     * @param \stdClass $alumno
     *
     * @return AlumnoEstadoCurso
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
     * Set curso
     *
     * @param \stdClass $curso
     *
     * @return AlumnoEstadoCurso
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return \stdClass
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return AlumnoEstadoCurso
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
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
}

