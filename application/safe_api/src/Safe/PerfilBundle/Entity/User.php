<?php

namespace Safe\PerfilBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
//http://mechanics.flite.com/blog/2014/07/29/using-innodb-large-prefix-to-avoid-error-1071/
/**
 * User
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="Safe\PerfilBundle\Repository\UserRepository")
 */
class User extends BaseUser
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
     * @ORM\Column(name="google_id", type="string", length=255, nullable=true, unique=true)
     */
    private $googleId;
    
     /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    protected $googleAccessToken;


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

    /**
     * Set googleId
     *
     * @param string $googleId
     *
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    function getGoogleAccessToken() {
        return $this->googleAccessToken;
    }

    function setGoogleAccessToken($googleAccessToken) {
        $this->googleAccessToken = $googleAccessToken;
    }


    

}

