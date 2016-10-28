<?php
namespace Safe\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Safe\AdminBundle\Form\RegistracionInstitutoType;
use Safe\CursoBundle\Entity\Curso;

use Safe\CoreBundle\Controller\SafeRestAbstractController;
use Safe\CoreBundle\Http\HttpMethod;
use Safe\CoreBundle\Exception\EntityNotFoundException;

use Doctrine\Common\Util\Debug;
use Doctrine\Common\Collections\ArrayCollection;

class InstitutoController extends SafeRestAbstractController {
    
    
    /**
     * Obtiene el instituto segun el  id
     *
     * @ApiDoc(     
     *   output = "Safe\InstitutoBundle\Entity\Instituto",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente",
     *     404 = "Entidad no encontrada"
     *   }
     * )
     *
     * @Annotations\View(templateVar="page")
     *
     * @param int     $id      id del curso.
     *
     * @return object
     *
     * @throws NotFoundHttpException cuando no existe el curso.
     */
    public function getInstitutoAction()
    {        
        try {            
            return $this->generarRespuesta($this->getInstitutoService()->obtenerInstitutoPorDefecto(), Response::HTTP_OK, array('Default', 'admin_listado'));
        } catch (EntityNotFoundException $ex) {
            return $this->generarRepuestaNotFount($this->traducir($ex->getMessage()));
        }
    } 
    
    /**
     * Actualiza los datos del instituto
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *   "razonSocial" : "Instituto Mirai Academy",
     *   "descripcion" : "<h1>Nombre del instituto</h1> <p>Historia....</p>" 
     *  }
     * ```
     * @ApiDoc(          
     *   statusCodes = {
     *     204 = "Entidad actualizada correctamente",
     *     400 = "Hubo un error al actualizar la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function putInstitutoAction(Request $request, $id) {                
        $instituto = $this->getInstitutoService()->getById($id);        
        if ($instituto == null) {                      
            throw  $this->createNotFoundException("institutoBundle.instituto.no_encontrado");
        }            
        return $this->procesarRequest($request, RegistracionInstitutoType::class, $instituto, HttpMethod::PUT);         
    }
    
    /**
     * Actualiza los datos parciales del instituto
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *   "razonSocial" : "Instituto Mirai Academy",
     *   "descripcion" : "<h1>Nombre del instituto</h1> <p>Historia....</p>" 
     *  }
     * ```
     * @ApiDoc(          
     *   statusCodes = {
     *     204 = "Entidad actualizada correctamente",
     *     400 = "Hubo un error al actualizar parcialmente la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function patchInstitutoAction(Request $request, $id) {                
        $instituto = $this->getInstitutoService()->getById($id);        
        if ($instituto == null) {        
            throw  $this->createNotFoundException("institutoBundle.instituto.no_encontrado");
        }   
        return $this->procesarRequest($request, RegistracionInstitutoType::class, $instituto, HttpMethod::PATCH); 
    }
        
    private function getInstitutoService() {
        return $this->container->get('safe_instituto.service.instituto');
    }
       
    
    
    protected function procesarEntidadValida($instituto, $method = HttpMethod::POST) {
        
        $this->getInstitutoService()->crearOActualizar($instituto);
        if (HttpMethod::POST == $method) {
            return $this->generarRespuesta($instituto, Response::HTTP_OK, array('Default', 'admin_listado'));
        }
        return $this->generarRepuestaNotContent();
    }
}
