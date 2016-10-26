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

use Safe\TemaBundle\Entity\Actividad;
use Safe\DocenteBundle\Form\RegistracionConceptoType;
use Doctrine\Common\Util\Debug;
//http://symfony.com/doc/current/bundles/FOSRestBundle/param_fetcher_listener.html
class ActividadImpartidaController extends SafeRestAbstractController {
    /**
     * Lista todos las actividades impartidos en un concepto.
     *
     * @ApiDoc(
     *   output = "array<Safe\TemaBundle\Entity\Concepto>",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Numero de pagina.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="Cantidad de elementos a retornar.")
     *
     * @Annotations\View(
     *  templateVar="pages"
     * )
     *
     * @param Request               $id      id del docente
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getActividadesAction($docenteId, $cursoId, $temaId, $conceptoId, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        return $this->generarRespuesta($this->getActividadImpartidaService()->findAll($conceptoId, $limit, $offset),
                Response::HTTP_OK,
                array('Default'));
    }
    
    /**
     * Obtiene el detalle de la actividad impartido por el docente.
     *
     * @ApiDoc(
     *   output = "Safe\TemaBundle\Entity\Concepto",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente",
     *     404 = "Concepto no econtrado"
     *   }
     * )
     *
     * @Annotations\View(templateVar="page")
     *
     * @param int     $docenteId      id del docente.
     * @param int     $cursoId      id del curso.
     * @param int     $temaId      id del tema.
     * @param int     $conceptoId      id del concepto. 
     * @param int     $actividadId      id de la actividad.
     * 
     * @return object
     *
     * @throws NotFoundHttpException cuando no existe el tema.
     */
    public function getActividadAction($docenteId, $cursoId, $temaId, $conceptoId, $actividadId) {
        $actividad = $this->getActividadImpartidaService()->getById($actividadId);
        //Debug::dump($actividad);
        return $this->generarRespuesta($actividad,
                Response::HTTP_OK,
                array('Default', 'docente_actividad_detalle'));
    }
    
    /**
     * Crea una nueva actividad.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *   "titulo" : "Actividad 1",
     *   "descripcion" : "Texto introductivo a la actividad" ,
     *   "ejercicio:" {"pregunta": "hola?", "respuesta":"chau"},
     *   "dificultad": 1.1,
     *   "discriminador": 0,
     *   "azar": 0,
     *   "d": 1.7
     *  }
     * ```
     * @ApiDoc(          
     *   output="Safe\TemaBundle\Entity\Actividad",
     *   statusCodes = {
     *     204 = "Entidad creadad correctamente",
     *     400 = "Hubo un error al crear la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function postActividadAction(Request $request, $docenteId, $cursoId, $temaId, $conceptoId) { 
       //TODO SECURITY
       $data = json_decode($request->getContent(), true);
       $validacion = $this->validarRequestData($data);
       if (!$validacion['resultado']) {
           return $this->generarRepuestaBadRequest($validacion['mensaje']);
       }
       $concepto = $this->getConceptoService()->getById($conceptoId);
       $actividad = $this->getActividadImpartidaService()->crearActividad($data, $concepto);
       return $this->procesarEntidadValida($actividad, HttpMethod::POST);      
      
    }
    
    /**
     * actualizar una actividad.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *   "titulo" : "Actividad 1",
     *   "descripcion" : "Texto introductivo a la actividad" ,
     *   "ejercicio:" {"pregunta": "hola?", "respuesta":"chau"},
     *   "dificultad": 1.1,
     *   "discriminador": 0,
     *   "azar": 0,
     *   "d": 1.7
     *  }
     * ```
     * @ApiDoc(          
     *   output="Safe\TemaBundle\Entity\Actividad",
     *   statusCodes = {
     *     204 = "Entidad creadad correctamente",
     *     400 = "Hubo un error al crear la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function putActividadAction(Request $request, $docenteId, $cursoId, $temaId, $conceptoId, $actividadId) { 
       //TODO SECURITY
       $data = json_decode($request->getContent(), true);
       $validacion = $this->validarRequestData($data);
       if (!$validacion['resultado']) {
           return $this->generarRepuestaBadRequest($validacion['mensaje']);
       }
       $actividad = $this->getActividadImpartidaService()->getById($actividadId);            
       if ($actividad == null) {                      
            throw  $this->createNotFoundException("temaBundle.actividad.no_encontrada");
       }  
       
       $actividad = $this->getActividadImpartidaService()->actualizarActividad($data, $actividad);
       return $this->procesarEntidadValida($actividad, HttpMethod::PUT);      
      
    }
      
    private function getActividadImpartidaService() {        
        return $this->container->get('safe_docente.service.actividad_impartida');       
    }
    
    private function getConceptoService() {        
        return $this->container->get('safe_tema.service.concepto');       
    }

    protected function procesarEntidadValida($actividad, $method = HttpMethod::POST) {
       $this->getActividadImpartidaService()->crearOActualizar($actividad);
        if (HttpMethod::POST == $method) {
            return $this->generarRespuesta($actividad, Response::HTTP_OK, array('Default', 'docente_actividad_detalle'));
        }
        return $this->generarRepuestaNotContent();
    }

    
    private function validarRequestData($data) {
        if (!array_key_exists('titulo', $data)) {
            return array('resultado' => false, 'mensaje' => $this->traducir("temaBundle.actividad.titulo.vacio"));
        }
        if (!array_key_exists('ejercicio', $data)) {
            return array('resultado' => false, 'mensaje' => $this->traducir("temaBundle.actividad.ejercicio.vacio"));
        }
        if (!array_key_exists('resultado', $data)) {
            return array('resultado' => false, 'mensaje' => $this->traducir("temaBundle.actividad.resultado.vacio"));
        }
        if (!array_key_exists('tipo', $data)) {
            return array('resultado' => false, 'mensaje' => $this->traducir("temaBundle.actividad.tipo.vacio"));
        }
        return array('resultado' => true);
    }
    
   
}
