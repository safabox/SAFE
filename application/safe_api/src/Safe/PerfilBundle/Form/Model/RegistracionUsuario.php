<?php
namespace Safe\PerfilBundle\Form\Model;

use Safe\PerfilBundle\Entity\Usuario;
use Symfony\Component\Validator\Constraints as Assert;


class RegistracionUsuario {
  /* 
   * @var Safe\PerfilBundle\Entity\Usuario
   */
  private $usuario;
  
  /* 
   * @var Safe\DocenteBundle\Entity\Docente
   */
  private $docente;
  
  /* 
   * @var Safe\AlumnoBundle\Entity\Alumno
   */
  private $alumno;
  
  public function getUsuario() {
      return $this->usuario;
  }

  public function getDocente() {
      return $this->docente;
  }

  public function getAlumno() {
      return $this->alumno;      
  }

  public function setUsuario($usuario) {
      $this->usuario = $usuario;
  }

  public function setDocente($docente) {
      $this->docente = $docente;
  }

  public function setAlumno($alumno) {
      $this->alumno = $alumno;
  }
  
  public function limpiarEntidadesSinRol() {
      if (!$this->existeRole(Usuario::ROLE_DOCENTE)) {
          $this->docente = null;
      }
      if (!$this->existeRole(Usuario::ROLE_ALUMNO)) {
          $this->alumno = null;
      }
  }
  
    /*
   * @Assert\IsTrue(message = "perfilBundle.usuario.docente.integridad")
   */
  /*public function isUsuarioDocenteIntegro() {     
    return $this->existeRole(Usuario::ROLE_DOCENTE) && $this->docente !== null;
  }*/
  /*
   * @Assert\IsTrue(message = "perfilBundle.usuario.alumno.integridad")
   */
  /*public function isUsuarioAlumnoIntegro() {
    return $this->existeRole(Usuario::ROLE_ALUMNO) && $this->alumno !== null;
  }*/
  
  protected function existeRole($rol) {
       if ($this->usuario !== null && $this->usuario->getRoles() !== null ) {
        $roles = $this->usuario->getRoles();
        return in_array($rol, $roles);
      }
      return false;  
  }

}
