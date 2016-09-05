<?php
namespace Safe\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcherInterface;

use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Safe\DocenteBundle\Entity\Docente;
use Safe\AdminBundle\Form\RegistracionDocenteType;

use Safe\CoreBundle\Controller\SafeRestAbstractController;
use Safe\CoreBundle\Http\HttpMethod;

use Doctrine\Common\Util\Debug;

class DocenteController extends SafeRestAbstractController {
    /**
     * Lista todos los docentes.
     *
     * @ApiDoc(
     *   resource = true,
     *   output="array<Safe\DocenteBundle\Entity\Docente>",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Número de página.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="Cantidad de elementos a retornar.")
     *
     * @Annotations\View(
     *  templateVar="pages"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getDocentesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
       
        return $this->generarRespuesta($this->getDocenteService()->findAll($limit, $offset), 
                Response::HTTP_OK,
                array('Default'));
    } 
    
    /**
     * Crea un nuevo docente
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *  "legajo":  "123457",
     *  "curriculum":  "<h3>Educaci&oacute;n<h3> <ul><li>Instituto 1</li><li>Instituto 2</li></ul>",
     *  "usuario": {
     *      "nombre": "Ruben",
     *      "apellido": "Aguirre",
     *      "username": "jirafales",
     *      "tipoDocumento":  "DNI",
     *      "numeroDocumento": "30777555",
     *      "genero": "Masculino",
     *      "email": "jirafales@organizacion.org",
     *      "enabled": "true",
     *      "plainPassword": {
     *          "first" : "123456",
     *          "second" : "123456"
     *      }
     *	}
     * } 
     * ```
     * @ApiDoc(          
     *   output="Safe\DocenteBundle\Entity\Docente",
     *   statusCodes = {
     *     200 = "Entidad creada correctamente",
     *     400 = "Hubo un error al crear la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function postDocenteAction(Request $request) {
        $docente = new Docente();
        $docente->setInstituto($this->obtenerInstitutoPorDefecto());
        return $this->procesarRequest($request, new RegistracionDocenteType(), $docente, HttpMethod::POST);          
    }
    
    /**
     * Actualiza los datos del docente
     * Nota: el usuario no debe existir.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *  "legajo":  "123457",
     *  "curriculum":  "<h3>Educaci&oacute;n<h3> <ul><li>Instituto 1</li><li>Instituto 2</li></ul>",
     *  "usuario": {
     *      "nombre": "Ruben",
     *      "apellido": "Aguirre",
     *      "username": "jirafales",
     *      "tipoDocumento":  "DNI",
     *      "numeroDocumento": "30777555",
     *      "genero": "Masculino",
     *      "email": "jirafales@organizacion.org",
     *      "enabled": "true",
     *      "plainPassword": {
     *          "first" : "123456",
     *          "second" : "123456"
     *      }
     *	}
     * } 
     * ```
     * @ApiDoc(          
     *   output="Safe\DocenteBundle\Entity\Docente",
     *   statusCodes = {
     *     204 = "Entidad actualizada correctamente",
     *     400 = "Hubo un error al actualizar la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function putDocenteAction(Request $request, $id) {                
        $docente = $this->getDocenteService()->getById($id);        
        if ($docente == null) {                      
            throw  $this->createNotFoundException("docenteBundle.docente.no_encontrado");
        }         
        return $this->procesarRequest($request, new RegistracionDocenteType(), $docente, HttpMethod::PUT);        
    }
    
    /**
     * Actualiza los datos parciales del docente
     * 
     * #### Ejemplo del Request     
    * ```
     * {
     *  "legajo":  "123457",
     *  "curriculum":  "<h3>Educaci&oacute;n<h3> <ul><li>Instituto 1</li><li>Instituto 2</li></ul>",
     *  "usuario": {
     *      "nombre": "Ruben",
     *      "apellido": "Aguirre",
     *      "username": "jirafales",
     *      "tipoDocumento":  "DNI",
     *      "numeroDocumento": "30777555",
     *      "genero": "Masculino",
     *      "email": "jirafales@organizacion.org",
     *      "enabled": "true",
     *      "plainPassword": {
     *          "first" : "123456",
     *          "second" : "123456"
     *      }
     *	}
     * } 
     * ```
     * @ApiDoc(          
     *   output="Safe\DocenteBundle\Entity\Docente",
     *   statusCodes = {
     *     204 = "entidad actualizada correctamente",
     *     400 = "Hubo un error al actualizar parcialmente la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function patchDocenteAction(Request $request, $id) {                
        $docente = $this->getDocenteService()->getById($id);        
        if ($docente == null) {        
            throw  $this->createNotFoundException("docenteBundle.docente.no_encontrado");
        }   
        return $this->procesarRequest($request, new RegistracionDocenteType(), $docente, HttpMethod::PATCH);
    }
    
    
    /**
     * Obtiene el docente según el id.
     *
     * @ApiDoc(     
     *   output = "Safe\DocenteBundle\Entity\Docente",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente",
     *     404 = "Docente no encontrado"
     *   }
     * )
     *
     * @Annotations\View(templateVar="page")
     *
     * @param int     $id      id del docente.
     *
     * @return object
     *
     * @throws NotFoundHttpException cuando no existe el alumno.
     */
    public function getDocenteAction($id)
    {
        return $this->generarRespuesta($this->getDocenteService()->getById($id), Response::HTTP_OK, array('Default', 'admin_detalle'));            
    }
    
    private function getDocenteService() {
        return $this->container->get('safe_docente.service.docente');
    }

    protected function procesarEntidadValida($docente, $method = HttpMethod::POST) {
        $this->getDocenteService()->crearOActualizar($docente);            
        if (HttpMethod::POST == $method) {            
            return $this->generarRespuesta($docente, Response::HTTP_OK, array('Default'));            
        }
        return $this->generarRepuestaNotContent();
    }

}
