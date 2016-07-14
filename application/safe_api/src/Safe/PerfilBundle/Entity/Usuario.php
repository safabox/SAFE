<?php

namespace Safe\PerfilBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Constraints as Assert;

//http://mechanics.flite.com/blog/2014/07/29/using-innodb-large-prefix-to-avoid-error-1071/
/**
 * Usuario
 *
 * @ORM\Table(name="usuario",
 *  uniqueConstraints={
 *     @ORM\UniqueConstraint(name="user_uk", columns={"nombre", "apellido"})
 *  }
 * )
 * @ORM\Entity(repositoryClass="Safe\PerfilBundle\Repository\UsuarioRepository")
 * 
 * 
 * @UniqueEntity(
 *     fields={"nombre", "apellido"},
 *     errorPath="apellido",
 *     message="perfilBundle.usuario.exists"
 * )
 */
class Usuario extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     * @Assert\NotBlank(
         *      message = "perfilBundle.usuario.nombre.not_blank"
     * )
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "perfilBundle.usuario.nombre.max"
     * )         
     */
    private $nombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=100, nullable=false)
     * @Assert\NotBlank(
     *      message = "perfilBundle.usuario.apellido.not_blank"
     * )
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "perfilBundle.usuario.apellido.max"
     * )
     *  
     */
    private $apellido;
    
    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "perfilBundle.usuario.avatar.max"
     * )
     */
    private $avatar;
    
    public function __construct()
    {
        parent::__construct();
        // your own logic
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



    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }


    /**
     * @Assert\NotBlank(
     *      message = "fos_user.username.blank"
     * )
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "fos_user.username.short",
     *      max = 255,
     *      maxMessage = "fos_user.username.long"
     * )
     */
    public function getUsername()
    {
        return parent::getUsername();
    }
    
    /**
     * @Assert\NotBlank(
     *      message = "fos_user.email.blank"
     * )
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "fos_user.email.short",
     *      max = 254,
     *      maxMessage = "fos_user.email.long"
     * )
     * @Assert\Email(
     *      message = "fos_user.email.invalid",
     * )
     */
    public function getEmail() {
        return parent::getEmail();
    }
    
    /**
     * @Assert\NotBlank(
     *      message = "fos_user.password.blank"
     * )
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "fos_user.password.short",
     *      max = 4096   
     * )
     */
    public function getPlainPassword() {
        return parent::getPlainPassword();
    }

}

