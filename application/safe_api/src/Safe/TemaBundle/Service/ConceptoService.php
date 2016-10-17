<?php
namespace Safe\TemaBundle\Service;

use Safe\TemaBundle\Repository\ConceptoRepository;

class ConceptoService {
    protected $conceptoRepository;

    public function __construct(ConceptoRepository $conceptoRepository)
    {
        $this->conceptoRepository = $conceptoRepository;
    }
    
    public function crearOActualizar($concepto) {        
        return $this->conceptoRepository->crearOActualizar($concepto);
    }
    
    public function findAll($temaId, $limit = 10, $offset = 0) {
        return $this->conceptoRepository->findBy(array('tema' => $temaId), null, $limit, $offset);
    }
        
    public function getById($id) {
        return $this->conceptoRepository->find($id);
    }
    
}
