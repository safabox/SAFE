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
class TemaImpartidoController extends SafeRestAbstractController {
    /**
     * Lista todos los temas impartidos por el docente.
     *
     * @ApiDoc(
     *   output = "array<Safe\TemaBundle\Entity\Tema>",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Numero de pagina.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", nullable=true, description="Cantidad de elementos a retornar.")
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
    public function getTemasAction($docenteId, $cursoId, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        return $this->generarRespuesta($this->getTemaImpartidoService()->findAll($cursoId, $limit, $offset),
                Response::HTTP_OK,
                array('Default'));
    } 
    
    /**
     * Obtiene el detalle del tema impartido por el docente.
     *
     * @ApiDoc(
     *   output = "Safe\TemaBundle\Entity\Tema",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente",
     *     404 = "Tema no econtrado"
     *   }
     * )
     *
     * @Annotations\View(templateVar="page")
     *
     * @param int     $temaId      id del tema.
     * @param int     $id      id del tema.
     *
     * @return object
     *
     * @throws NotFoundHttpException cuando no existe el tema.
     */
    public function getTemaAction($docenteId, $cursoId, $temaId)
    {      
        return $this->generarRespuesta($this->getTemaImpartidoService()->getById($temaId),
                Response::HTTP_OK,
                array('Default', 'docente_tema_detalle'));
    }
    
    /**
     * Crea un nuevo tema.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *   "titulo" : "Suma",
     *   "descripcion" : "<h1>Curso inical de matemáticas</h1> <p>El objetivo del curso...</p>" ,
     *   "orden:" 1,
     *   "predecesoras": ["13"],
     *   "sucesoras": ["9", "10"]
     *  }
     * ```
     * @ApiDoc(          
     *   output="Safe\TemaBundle\Entity\Tema",
     *   statusCodes = {
     *     204 = "Entidad creadad correctamente",
     *     400 = "Hubo un error al crear la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function postTemaAction(Request $request, $docenteId, $cursoId) { 
       //TODO SECURITY
        $tema = new Tema();
        $curso = $this->getCursoService()->getById($cursoId);
        $tema->setCurso($curso);
        return $this->procesarRequest($request, RegistracionTemaType::class, $tema, HttpMethod::POST);        
    }
    
    /**
     * Actualiza un tema.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *   "titulo" : "Suma",
     *   "descripcion" : "<h1>Curso inical de matemáticas</h1> <p>El objetivo del curso...</p>" ,
     *   "orden:" 1,
     *   "predecesoras": ["13"]
     *  }
     * ```
     * @ApiDoc(          
     *   output="Safe\TemaBundle\Entity\Tema",
     *   statusCodes = {
     *     204 = "Entidad creadad correctamente",
     *     400 = "Hubo un error al crear la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function putTemaAction(Request $request, $docenteId, $cursoId, $temaId) {                
        //TODO SECURITY
        $tema = $this->getTemaImpartidoService()->getById($temaId);            
        if ($tema == null) {                      
            throw  $this->createNotFoundException("temaBundle.tema.no_encontrado");
        }            
        return $this->procesarRequest($request, RegistracionTemaType::class, $tema, HttpMethod::PUT);         
    }
    
    /**
     * Actualiza un atributo del tema.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *   "titulo" : "Suma",
     *   "descripcion" : "<h1>Curso inical de matemáticas</h1> <p>El objetivo del curso...</p>" ,
     *   "orden:" 1,
     *   "predecesoras": ["13"],
     *  }
     * ```
     * @ApiDoc(          
     *   output="Safe\TemaBundle\Entity\Tema",
     *   statusCodes = {
     *     204 = "Entidad creadad correctamente",
     *     400 = "Hubo un error al crear la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function patchTemaAction(Request $request, $docenteId, $cursoId, $temaId) {                
        //TODO SECURITY
        $tema = $this->getTemaImpartidoService()->getById($temaId);            
        if ($tema == null) {                      
            throw  $this->createNotFoundException("temaBundle.tema.no_encontrado");
        }            
        return $this->procesarRequest($request, RegistracionTemaType::class, $tema, HttpMethod::PATCH);         
    }
      
    private function getTemaImpartidoService() {        
        return $this->container->get('safe_docente.service.tema_impartido');       
    }
    
    private function getCursoService() {        
        return $this->container->get('safe_curso.service.curso');       
    }

    protected function procesarEntidadValida($tema, $method = HttpMethod::POST) {
        if (HttpMethod::PUT == $method || HttpMethod::PATCH == $method) {
            $predecesoras = $tema->getPredecesoras()->filter(
                function($entry) {
                    return ($entry !== '' || $entry !== NULL);
                }
            );
            $tema->setPredecesoras($predecesoras);       
        }
        $this->getTemaImpartidoService()->crearOActualizar($tema);
        if (HttpMethod::POST == $method) {
            return $this->generarRespuesta($tema, Response::HTTP_OK, array('Default', 'docente_tema_detalle'));
        }
        return $this->generarRepuestaNotContent();
    }

}
