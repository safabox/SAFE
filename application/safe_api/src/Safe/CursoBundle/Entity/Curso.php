<?php

namespace Safe\CursoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;

use Safe\InstitutoBundle\Entity\Instituto;
/**
 * Curso
 *
 * @ORM\Table(name="curso")
 * @ORM\Entity(repositoryClass="Safe\CursoBundle\Repository\CursoRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(name="titulo", type="string", length=100)
     * @Assert\NotBlank(
     *      message = "cursoBundle.curso.titulo.vacio"
     * ) 
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "cursoBundle.curso.titulo.max"
     * )   
     * @Expose
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)     
     * @Expose
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
     * @var \DateTime
     *
     * @ORM\Column(name="fechaModificacion", type="datetime", nullable=true)
     * @Expose
     */
    private $fechaModificacion;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Safe\DocenteBundle\Entity\Docente", inversedBy="cursos")
     * @ORM\JoinTable(name="curso_docente")     
     */
    private $docentes;

    /**
     * @ORM\ManyToMany(targetEntity="Safe\AlumnoBundle\Entity\Alumno", inversedBy="cursos")
     * @ORM\JoinTable(name="curso_alumno")     
     */
    private $alumnos;
    
     /**
     *
     * @ORM\OneToMany(targetEntity="Safe\TemaBundle\Entity\Tema", mappedBy="curso")
     * 
     */
    private $temas;
    
    /**
     * @ORM\ManyToOne(targetEntity="Safe\InstitutoBundle\Entity\Instituto")
     * @ORM\JoinColumn(name="instituto_id", referencedColumnName="id")
     */    
    private $instituto;

    public function __construct()
    {
        $this->alumnos = new ArrayCollection();
        $this->setFechaCreacion(new \DateTime());
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function actualizarFechaModificacion() {
        $this->setFechaModificacion(new \DateTime());
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

    function getTitulo() {
        return $this->titulo;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
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
     * Set docentes
     *
     * @param \stdClass $docente
     * @return Curso
     */
    public function setDocentes($docentes)
    {        
        $this->docentes = $docentes;
        return $this;
    }

    /**
     * Get docentes
     *
     * @return \stdClass 
     */
    public function getDocentes()
    {
        return $this->docentes;
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
    
    /**
     * Set temas
     *
     * @param Collection $temas
     * @return Tema
     */
    public function setTemas($temas)
    {
        $this->temas = $temas;

        return $this;
    }

    /**
     * Get temas
     *
     * @return Collection
     */
    public function getTemas()
    {
        return $this->temas;
    }
    
    function getInstituto() {
        return $this->instituto;
    }

    function setInstituto($instituto) {
        $this->instituto = $instituto;
    }


    function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    function setFechaModificacion(\DateTime $fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }


}
