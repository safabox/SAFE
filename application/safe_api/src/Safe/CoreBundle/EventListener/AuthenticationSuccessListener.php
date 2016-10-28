<?php
namespace Safe\CoreBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Safe\DocenteBundle\Service\DocenteService;
use Safe\AlumnoBundle\Service\AlumnoService;

class AuthenticationSuccessListener {
    
    private $docenteService;
    private $alumnoService;
    
    public function __construct(DocenteService $docenteService, AlumnoService $alumnoService)
    {
        $this->docenteService = $docenteService;
        $this->alumnoService = $alumnoService;
    }
    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        // $data['token'] contains the JWT

        $data['roles'] = $user->getRoles();        
        if (in_array("ROLE_ALUMNO", $data['roles'] )) {
            $alumno = $this->alumnoService->buscarPorUsuario($user);
            if ($alumno != null) {
                $data['idAlumno'] = $alumno->getId();
            }
        }
        if (in_array("ROLE_DOCENTE", $data['roles'] )) {
            $docente = $this->docenteService->buscarPorUsuario($user);
            if ($docente != null) {
                $data['idDocente'] = $docente->getId();
            }
        }
        
        $event->setData($data);
    }
}
