<?php
namespace Safe\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Request\ParamFetcherInterface;

use JMS\Serializer\SerializationContext;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Safe\AdminBundle\Entity\Dashboard;
use Safe\CoreBundle\Controller\SafeRestAbstractController;

class DashboardController extends SafeRestAbstractController {
    /**
     * Muestra el dashboard del admin
     *
     * @ApiDoc(     
     *   resource = true,     
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente"
     *   }
     * )
     *
     *
     * @return array
     */
    public function getDashboardsAction(Request $request)
    {
        $totalCursos = $this->getCursoService()->cantidadCursos($this->obtenerInstitutoPorDefecto());
        $totalDocente = $this->getDocenteService()->cantidadDocentes($this->obtenerInstitutoPorDefecto());
        $totalAlumnos = $this->getAlumnoService()->cantidadAlumnos($this->obtenerInstitutoPorDefecto());
    
        return $this->generarRespuesta(new Dashboard($totalCursos, $totalDocente, $totalAlumnos), Response::HTTP_OK);
    } 
    
    private function getAlumnoService() {
        return $this->container->get('safe_alumno.service.alumno');
    }
    private function getDocenteService() {
        return $this->container->get('safe_docente.service.docente');
    }
    private function getCursoService() {
        return $this->container->get('safe_curso.service.curso');
    }

    protected function procesarEntidadValida($data, $method = HttpMethod::POST) {
        
    }

}
