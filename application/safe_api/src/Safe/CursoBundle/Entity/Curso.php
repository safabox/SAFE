<?php

namespace Safe\CursoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

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
     * @ORM\Column(name="copete", type="text", nullable=true)
     * @Expose
     */
    private $copete;
    
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)     
     * @Expose
     * @Groups({"admin_detalle", "docente_detalle", "alumno_curso_detalle"}) 
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
     * @Expose
     * @Groups({"docente_detalle", "alumno_curso_detalle"})
     */
    private $docentes;

    /**
     * @ORM\ManyToMany(targetEntity="Safe\AlumnoBundle\Entity\Alumno", inversedBy="cursos")
     * @ORM\JoinTable(name="curso_alumno")
     * @Expose
     * @Groups({"docente_detalle", "alumno_curso_detalle"})      
     */
    private $alumnos;
    
     /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Safe\TemaBundle\Entity\Tema", mappedBy="curso")
     * @Expose
     * @Groups({"docente_detalle"})      
     */
    private $temas;
    
     /**
     * @var boolean 
     * @ORM\Column(name="habilitado", type="boolean")
     * 
     * @Expose
     * 
     */
    private $habilitado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Safe\InstitutoBundle\Entity\Instituto")
     * @ORM\JoinColumn(name="instituto_id", referencedColumnName="id")
     */    
    private $instituto;
    
    /**
     * @ORM\OneToMany(targetEntity="Safe\TemaBundle\Entity\AlumnoEstadoCurso", mappedBy="curso")
     * 
     */
    private $estadosAlumnos;
    
    
    private $cantAlumnosFinalizados;

    public function __construct()
    {
        $this->alumnos = new ArrayCollection();
        $this->temas = new ArrayCollection();
        $this->estadosAlumnos = new ArrayCollection();
        $this->habilitado = true;
        $this->setFechaCreacion(new \DateTime());
        $this->cantAlumnosFinalizados = 0;
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

    function getCopete() {
        return $this->copete;
    }

    function setCopete($copete) {
        $this->copete = $copete;
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


    function getHabilitado() {
        return $this->habilitado;
    }

    function setHabilitado($habilitado) {
        $this->habilitado = $habilitado;
    }

    function getEstadosAlumnos() {
        return $this->estadosAlumnos;
    }

    function setEstadosAlumnos($estadosAlumnos) {
        $this->estadosAlumnos = $estadosAlumnos;
    }
    
    //Transient
     /**
     * @Groups({"docente_curso_list"}) 
     * @VirtualProperty 
     * @return type string
     */
    function getCantAlumnos() {
        return $this->alumnos->count();
    }
     /**
     * @Groups({"docente_curso_list"}) 
     * @VirtualProperty 
     * @return type string
     */
    function getCantAlumnosFinalizados() {
        return $this->cantAlumnosFinalizados;
    }

    function setCantAlumnosFinalizados($cantAlumnosFinalizados) {
        $this->cantAlumnosFinalizados = $cantAlumnosFinalizados;
    }


}
