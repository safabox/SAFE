<?php
namespace Safe\DocenteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Request\ParamFetcherInterface;

use JMS\Serializer\SerializationContext;

use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Safe\CoreBundle\Http\HttpMethod;

use Safe\CoreBundle\Controller\SafeRestAbstractController;

use Safe\TemaBundle\Entity\Tema;
use Safe\DocenteBundle\Form\RegistracionTemaType;
use Doctrine\Common\Util\Debug;
//http://symfony.com/doc/current/bundles/FOSRestBundle/param_fetcher_listener.html
class AlumnoAsignadoConceptoController extends SafeRestAbstractController {
        
    /**
     * Obtiene el detalle del alumno impartido por el docente.
     *
     * @ApiDoc(
     *   output = "Safe\DocenteBundle\Entity\AlumnoEstadistica",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente",
     *     404 = "Tema no econtrado"
     *   }
     * )
     *
     * @Annotations\View(templateVar="page")
     *
     * @param int     $docenteId      id del docente.
     * @param int     $cursoId      id del curso.
     * @param int     $alumnoId      id del alumno. 
     * @param int     $conceptoId      id del concepto. 
     *
     * @return object
     *
     * @throws NotFoundHttpException cuando no existe el tema.
     */
    public function getAlumnosConceptoEstadisticaAction($docenteId, $cursoId, $alumnoId, $conceptoId)
    {      
        return $this->generarRespuesta($this->getConceptoImpartidoService()->getEstadisticaConceptoFullAlumno($conceptoId, $alumnoId),
                Response::HTTP_OK,
                array('Default', 'docente_estadistica_detalle'));
       
    }
    
    private function getConceptoImpartidoService() {        
        return $this->container->get('safe_docente.service.concepto_impartido');       
    }
    
    private function getCursoService() {        
        return $this->container->get('safe_curso.service.curso');       
    }

    protected function procesarEntidadValida($tema, $method = HttpMethod::POST) {
      
    }
    

}
