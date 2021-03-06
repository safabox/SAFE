<?php

namespace Safe\AlumnoBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
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
 * Alumno
 *
 * @ORM\Table(name="alumno",
 *  uniqueConstraints={
 *     @ORM\UniqueConstraint(name="alumn_leg_uk", columns={"legajo", "instituto_id"})
 *  }
 * )
 * @ORM\Entity(repositoryClass="Safe\AlumnoBundle\Repository\AlumnoRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 * @UniqueEntity(
 *     fields={"legajo", "instituto"},
 *     errorPath="legajo",
 *     message="alumnoBundle.alumno.legajo.existe"
 * )  
 */
class Alumno
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
     * @ORM\Column(name="legajo", type="string", length=100, nullable=true)
     * @Expose
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "alumnoBundle.alumno.legajo.max"
     * ) 
     */
    private $legajo;
    
    /**
     * @ORM\ManyToOne(targetEntity="Safe\PerfilBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)     
     * @Assert\Valid
     * @Expose
     */
    private $usuario;


    /**
     * @ORM\ManyToMany(targetEntity="Safe\CursoBundle\Entity\Curso", mappedBy="alumnos")
     * @Expose
     * @Groups({"admin_detalle", "detalle"})
     */
    private $cursos;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Safe\InstitutoBundle\Entity\Instituto")
     * @ORM\JoinColumn(name="instituto_id", referencedColumnName="id", nullable=false)
     */    
    private $instituto;
    
        /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime", nullable=true)
     * @Expose
     * @Groups({"admin_detalle", "detalle"})
     */
    private $fechaCreacion;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaModificacion", type="datetime", nullable=true)
     * @Expose      
     */
    private $fechaModificacion;

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
    
    /**
     * Set cursos
     *
     * @param ArrayCollection $cursos
     * @return Alumno
     */
    public function setCursos($cursos)
    {
        $this->cursos = $cursos;

        return $this;
    }

    /**
     * Get cursos
     *
     * @return ArrayCollection 
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
        $this->usuario->setRoles(array(Usuario::ROLE_ALUMNO));
    }
    
    function getInstituto() {
        return $this->instituto;
    }

    function setInstituto($instituto) {
        $this->instituto = $instituto;
    }

    function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    function setFechaCreacion(\DateTime $fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    function setFechaModificacion(\DateTime $fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }



}
