<?php

namespace Safe\PerfilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoDocumento
 *
 * @ORM\Table(name="tipo_documento")
 * @ORM\Entity(repositoryClass="Safe\PerfilBundle\Repository\TipoDocumentoRepository")
 */
class TipoDocumento
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
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=25, unique=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=100, unique=true)
     */
    private $descripcion;

    
    function setId($id) {
        $this->id = $id;
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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return TipoDocumento
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }
    
    function getDescripcion() {
        return $this->descripcion;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }


}

