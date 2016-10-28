<?php
namespace Safe\PerfilBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Safe\CoreBundle\DataFixtures\ORM\CoreData;
use Safe\PerfilBundle\Entity\Usuario;
use Safe\PerfilBundle\Entity\TipoDocumento;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class PerfilDataAbstract extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    protected function crearUsuario($username='usuario', $passwordPlano='123456', $roles=array('ROLE_USER')) {
        $usuario = new Usuario();
        $usuario->setNombre($username.'_Nombre');
        $usuario->setApellido($username.'_Apellido');
        $usuario->setEmail($username.'@mail.com');
        $usuario->setEnabled(true);
        
        $usuario->setNumeroDocumento(microtime());
        $usuario->setTipoDocumento($this->getReference('DNI'));
        
        
        $usuario->setUsername($username);        
        $usuario->setRoles($roles); 
        //$usuario->setSalt(md5(uniqid()));
            
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($usuario, $passwordPlano);    
        $usuario->setPassword($password);
        
        return $usuario;
    }
        
}
