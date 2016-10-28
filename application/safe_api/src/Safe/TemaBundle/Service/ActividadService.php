<?php
namespace Safe\TemaBundle\Service;

use Safe\TemaBundle\Repository\ActividadRepository;

class ActividadService {
    protected $actividadRepository;

    public function __construct(ActividadRepository $actividadRepository)
    {
        $this->actividadRepository = $actividadRepository;
    }
    
    public function crearOActualizar($actividad) {        
        return $this->actividadRepository->crearOActualizar($actividad);
    }
    
    public function findAll($conceptoId, $limit, $offset = 0) {
        return $this->actividadRepository->findBy(array('concepto' => $conceptoId), null, $limit, $offset);
    }
        
    public function getById($id) {
        return $this->actividadRepository->find($id);
    }
    
}
