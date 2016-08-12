<?php
namespace Safe\InstitutoBundle\Service;

use Safe\CoreBundle\Service\SafeCRUDAbstractService;
use Safe\InstitutoBundle\Repository\InstitutoRepository;

use Safe\CoreBundle\Exception\EntityNotFoundException;

class InstitutoService extends SafeCRUDAbstractService {
    
    private $institutoRepository;

    public function __construct(InstitutoRepository $institutoRepository)
    {
        $this->institutoRepository = $institutoRepository;
    }
    
    protected function getRepository(){
        return $this->institutoRepository;
    }
     
    public function obtenerInstitutoPorDefecto() {
        $result = $this->getRepository()->createQueryBuilder('instituto')                                       
                                       ->getQuery()
                                       ->setMaxResults(1)
                                       ->getResult();
        if (empty($result)) throw new EntityNotFoundException('institutoBundle.instituto.no_encontrado');
        return $result[0];       
    }

}
