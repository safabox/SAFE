<?php
namespace Safe\PerfilBundle\Service;

use Safe\CoreBundle\Service\SafeCRUDAbstractService;
use Safe\InstitutoBundle\Repository\InstitutoRepository;

use Safe\CoreBundle\Exception\EntityNotFoundException;


use Safe\PerfilBundle\Repository\TipoDocumentoRepository;

class TipoDocumentoService extends SafeCRUDAbstractService {
    private $tipoDocumentoRepository;

    public function __construct(TipoDocumentoRepository $tipoDocumentoRepository)
    {
        $this->tipoDocumentoRepository = $tipoDocumentoRepository;
    }
    
    protected function getRepository(){
        return $this->tipoDocumentoRepository;
    }
    
}
