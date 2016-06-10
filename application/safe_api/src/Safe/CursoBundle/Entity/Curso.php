<?php

namespace Safe\CursoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
/**
 * Curso
 *
 * @ORM\Table(name="curso")
 * @ORM\Entity(repositoryClass="Safe\CursoBundle\Repository\CursoRepository")
 * @ExclusionPolicy("all")
 */
class Curso
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     * @Expose
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     * @Groups({"curso_listado", "curso_detalle"})
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime", nullable=true)
     * @Expose
     */
    private $fechaCreacion;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Safe\DocenteBundle\Entity\Docente")
     * @Groups({"curso_detalle"})
     */
    private $docente;

  
    
    /**
     * @ORM\ManyToMany(targetEntity="Safe\AlumnoBundle\Entity\Alumno", inversedBy="cursos")
     * @ORM\JoinTable(name="curso_alumno")
     * @Groups({"curso_detalle"})
     */
    private $alumnos;

    public function __construct()
    {
        $this->alumnos = new ArrayCollection();
    }

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
     * Set nombre
     *
     * @param string $nombre
     * @return Curso
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Curso
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Curso
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set docente
     *
     * @param \stdClass $docente
     * @return Curso
     */
    public function setDocente($docente)
    {        
        $this->docente = $docente;
        return $this;
    }

    /**
     * Get docente
     *
     * @return \stdClass 
     */
    public function getDocente()
    {
        return $this->docente;
    }

    /**
     * Set alumnos
     *
     * @param ArrayCollection $alumnos
     * @return Curso
     */
    public function setAlumnos($alumnos)
    {
        $this->alumnos = $alumnos;

        return $this;
    }

    /**
     * Get alumnos
     *
     * @return ArrayCollection 
     */
    public function getAlumnos()
    {
        return $this->alumnos;
    }
}
