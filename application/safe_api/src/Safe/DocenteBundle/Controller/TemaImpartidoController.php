<?php
namespace Safe\DocenteBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcherInterface;

use JMS\Serializer\SerializationContext;

use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Safe\CoreBundle\Controller\SafeRestAbstractController;

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
    public function getTemasAction($docenteId, $cursoId, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        //$view = $this->view();
        //$view->setSerializationContext(SerializationContext::create()->setGroups(array('docente_curso_listado')));
       
        return $this->getTemaImpartidoService()->findAll($cursoId, $limit, $offset);
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
    public function getTemaAction($cursoId, $id)
    {      
        $tema =  $this->getTemaImpartidoService()->getById($id);
        return $tema;
    }
    
    
    private function getTemaImpartidoService() {
        
        return $this->container->get('safe_docente.service.tema_impartido');       
    }

    protected function procesarEntidadValida($data, $method = HttpMethod::POST) {
        
    }

}
