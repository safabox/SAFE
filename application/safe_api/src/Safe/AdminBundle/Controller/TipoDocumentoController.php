<?php
namespace Safe\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Request\ParamFetcherInterface;

use JMS\Serializer\SerializationContext;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;


//http://symfony.com/doc/current/bundles/FOSRestBundle/param_fetcher_listener.html
class TipoDocumentoController extends FOSRestController {
    /**
     * Listado de todos los tipos de documentos disponibles.
     *
     * @ApiDoc(     
     *   resource = true,
     *   output="array<Safe\PerfilBundle\Entity\Usuario>",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Número de página.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", nullable=true, description="Cantidad de elementos a retornar.")
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
    public function getTipoDocumentosAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->getTipoDocumentoService()->findAll($limit, $offset);
    } 
    
    private function getTipoDocumentoService() {
        return $this->container->get('safe_perfil.service.tipo_documento');
    }
}
