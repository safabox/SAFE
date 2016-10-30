<?php
namespace Safe\DocenteBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcherInterface;

use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Safe\CoreBundle\Controller\SafeRestAbstractController;

//http://symfony.com/doc/current/bundles/FOSRestBundle/param_fetcher_listener.html
class CursoImpartidoController extends SafeRestAbstractController {
    /**
     * Lista todos los cusos impartidos por el docente.
     *
     * @ApiDoc(
     *   output = "array<Safe\CursoBundle\Entity\Curso>",
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
    public function getCursosAction($id, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        $cursos = $this->getCursoImpartidoService()->findAllByDocente($id, $limit, $offset);
        return $this->generarRespuesta($cursos,
                Response::HTTP_OK,
                array('Default', 'docente_curso_list'));
    } 
    
    /**
     * Obtiene el detalle del curso impartido por el docente.
     *
     * @ApiDoc(
     *   output = "Safe\CursoBundle\Entity\Curso",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente",
     *     404 = "Curso no econtrado"
     *   }
     * )
     *
     * @Annotations\View(templateVar="page")
     *
     * @param int     $docenteId      id del docente.
     * @param int     $id      id del curso.
     *
     * @return object
     *
     * @throws NotFoundHttpException cuando no existe el curso.
     */
    public function getCursoAction($docenteId, $id)
    {      
        $curso =  $this->getCursoImpartidoService()->getById($id);
        return $this->generarRespuesta($curso,
                Response::HTTP_OK,
                array('Default', 'docente_detalle'));
    }
    
    
    private function getCursoImpartidoService() {
        
        return $this->container->get('safe_docente.service.curso_impartido');       
    }
    
    protected function procesarEntidadValida($curso, $method = HttpMethod::POST){

    }
}
