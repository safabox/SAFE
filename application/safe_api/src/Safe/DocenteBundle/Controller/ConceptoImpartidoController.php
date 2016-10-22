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

use Safe\TemaBundle\Entity\Concepto;
use Safe\DocenteBundle\Form\ConceptoForm;
use Safe\DocenteBundle\Form\RegistracionConceptoType;
use Safe\DocenteBundle\Form\RegistracionConceptoFormType;
use Doctrine\Common\Util\Debug;
//http://symfony.com/doc/current/bundles/FOSRestBundle/param_fetcher_listener.html
class ConceptoImpartidoController extends SafeRestAbstractController {
    /**
     * Lista todos los conceptos impartidos por el docente.
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
    public function getConceptosAction($docenteId, $cursoId, $temaId, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        return $this->generarRespuesta($this->getConceptoImpartidoService()->findAll($temaId, $limit, $offset),
                Response::HTTP_OK,
                array('Default'));
    } 
    
    /**
     * Obtiene el detalle del concepto impartido por el docente.
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
     *
     * @return object
     *
     * @throws NotFoundHttpException cuando no existe el tema.
     */
    public function getConceptoAction($docenteId, $cursoId, $temaId, $conceptoId)
    {      
        return $this->generarRespuesta($this->getConceptoImpartidoService()->getById($conceptoId),
                Response::HTTP_OK,
                array('Default', 'docente_concepto_detalle'));
    }
    
    /**
     * Crea un nuevo concepto.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *   "titulo" : "Suma",
     *   "descripcion" : "sumar numeros" ,
     *   "orden:" 1,
     *   "predecesoras": ["13"],
     *   "sucesoras": ["9", "10"],
     *   "tipo": "RASH",
     *   "rango": [-3, 3],
     *   "metodo": "THETA_MLE",
     *   "incremento": 0.1
     *  }
     * ```
     * @ApiDoc(          
     *   output="Safe\TemaBundle\Entity\Concepto",
     *   statusCodes = {
     *     204 = "Entidad creadad correctamente",
     *     400 = "Hubo un error al crear la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function postConceptoAction(Request $request, $docenteId, $cursoId, $temaId) { 
       //TODO SECURITY
        $conceptoForm = new ConceptoForm();
        $tema = $this->getTemaService()->getById($temaId);
        $conceptoForm->setTema($tema);
        return $this->procesarRequest($request, RegistracionConceptoFormType::class, $conceptoForm, HttpMethod::POST);        
        
    }
    
    /**
     * Actualiza un concepto
     * 
     * #### Ejemplo del Request     
     * ```
     *  {
     *   "titulo" : "Suma",
     *   "descripcion" : "sumar numeros" ,
     *   "orden:" 1,
     *   "predecesoras": ["13"],
     *   "sucesoras": ["9", "10"],
     *   "tipo": "RASH",
     *   "rango": [-3, 3],
     *   "metodo": "THETA_MLE",
     *   "incremento": 0.1
     *  }
     * ```
     * @ApiDoc(          
     *   output="Safe\TemaBundle\Entity\Concepto",
     *   statusCodes = {
     *     204 = "Entidad creadad correctamente",
     *     400 = "Hubo un error al crear la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function putConceptoAction(Request $request, $docenteId, $cursoId, $temaId, $conceptoId) {                
        //TODO SECURITY
        $conceptoForm = new ConceptoForm();
        $concepto = $this->getConceptoImpartidoService()->getById($conceptoId);            
        if ($concepto == null) {                      
            throw  $this->createNotFoundException("temaBundle.concepto.no_encontrado");
        }            
        $conceptoForm->setConcepto($concepto);        
        return $this->procesarRequest($request, RegistracionConceptoFormType::class, $conceptoForm, HttpMethod::PUT); 
    }
      
    private function getConceptoImpartidoService() {        
        return $this->container->get('safe_docente.service.concepto_impartido');       
    }
    
    private function getTemaService() {        
        return $this->container->get('safe_tema.service.tema');       
    }

    protected function procesarEntidadValida($conceptoForm, $method = HttpMethod::POST) {
        if (HttpMethod::PUT == $method || HttpMethod::PATCH == $method) {
            $predecesoras = $conceptoForm->getPredecesoras()->filter(
                function($entry) {
                    return ($entry !== '' || $entry !== NULL);
                }
            );
            $sucesoras = $conceptoForm->getSucesoras()->filter(
                function($entry) {                    
                    return ($entry !== NULL && $entry !== '');
                }
            );            
            $conceptoForm->setPredecesoras($predecesoras);       
            $conceptoForm->setSucesoras($sucesoras);       
            
            $concepto = $conceptoForm->mergeConcepto($conceptoForm->getConcepto());
            $itemBank = $conceptoForm->mergeItemBank($concepto->getItemBank());
            $concepto->setItemBank($itemBank);                        
        } else if (HttpMethod::POST == $method) {
            $concepto = $conceptoForm->createConcepto();
            $itemBank = $conceptoForm->createItemBank();
            $concepto->setItemBank($itemBank);
        }
        $this->getConceptoImpartidoService()->crearOActualizar($concepto);
        if (HttpMethod::POST == $method) {
            return $this->generarRespuesta($concepto, Response::HTTP_OK, array('Default', 'docente_concepto_detalle'));
        }
        return $this->generarRepuestaNotContent();
    }

}
