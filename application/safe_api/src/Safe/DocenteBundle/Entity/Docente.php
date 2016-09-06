<?php

namespace Safe\DocenteBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Safe\PerfilBundle\Entity\Usuario;

use Safe\InstitutoBundle\Entity\Instituto;
/**
 * Docente
 * @ORM\Table(name="docente", 
 *  uniqueConstraints={
 *     @ORM\UniqueConstraint(name="doc_leg_uk", columns={"legajo", "instituto_id"})
 *  }
 * )
 * @ORM\Entity(repositoryClass="Safe\DocenteBundle\Repository\DocenteRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 * @UniqueEntity(
 *     fields={"legajo", "instituto"},
 *     errorPath="legajo",
 *     message="docenteBundle.docente.legajo.existe"
 * ) 
 */
class Docente
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
     * @ORM\ManyToOne(targetEntity="Safe\PerfilBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     * @Expose
     * @Assert\Valid 
     */
    private $usuario;
    
    /**
     * @var string
     *
     * @ORM\Column(name="legajo", type="string", length=100, nullable=true)
     * @Expose
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "docenteBundle.docente.legajo.max"
     * ) 
     */
    private $legajo;

    /**
     * @var string
     *
     * @ORM\Column(name="curriculum", type="text", nullable=true)
     * @Expose
     * @Groups({"admin_detalle"})  
     */
    private $curriculum;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime", nullable=true)
     * @Expose
     * @Groups({"admin_detalle"})
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
     * @ORM\ManyToMany(targetEntity="Safe\CursoBundle\Entity\Curso", mappedBy="docentes")
     * @Expose
     * @Groups({"admin_detalle"})
     */
    private $cursos;
    
    /**
     * @ORM\ManyToOne(targetEntity="Safe\InstitutoBundle\Entity\Instituto")
     * @ORM\JoinColumn(name="instituto_id", referencedColumnName="id")
     */    
    private $instituto;

    
    public function __construct()
    {
        $this->setFechaCreacion(new \DateTime());
    }
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function actualizarFechaModificacion()
    {
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

    function setId($id) {
        $this->id = $id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Docente
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set curriculum
     *
     * @param string $curriculum
     * @return Docente
     */
    public function setCurriculum($curriculum)
    {
        $this->curriculum = $curriculum;

        return $this;
    }

    /**
     * Get curriculum
     *
     * @return string 
     */
    public function getCurriculum()
    {
        return $this->curriculum;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Docente
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime 
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }
    
    /**
     * Set cursos
     *
     * @param Collection $cursos
     * @return Docente
     */
    public function setCursos($cursos)
    {
        $this->cursos = $cursos;

        return $this;
    }

    /**
     * Get cursos
     *
     * @return Collection
     */
    public function getCursos()
    {
        return $this->cursos;
    }
    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    
       
    public function setRol() {
        $this->usuario->setRoles(array(Usuario::ROLE_DOCENTE));
    }

    
    public function getNombreYApellido() {
        return $this->usuario->getNombre().', '.$this->usuario->getApellido();
    }
    
    function getInstituto() {
        return $this->instituto;
    }

    function setInstituto($instituto) {
        $this->instituto = $instituto;
    }
    
    /**
     * Set legajo
     *
     * @param string $legajo
     * @return Alumno
     */
    public function setLegajo($legajo)
    {
        $this->legajo = $legajo;

        return $this;
    }

    /**
     * Get legajo
     *
     * @return string 
     */
    public function getLegajo()
    {
        return $this->legajo;
    }

    function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    function setFechaCreacion(\DateTime $fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }


}
