<?php
namespace Safe\AlumnoBundle\Service;

use Safe\TemaBundle\Repository\ActividadRepository;
use Safe\CatBundle\Service\CATService;

use Safe\TemaBundle\Service\ActividadService;
use Doctrine\Common\Util\Debug;
class ActividadAsignadaService extends ActividadService {

    private $catService;
    
    public function __construct(ActividadRepository $actividadRepository, CATService $catService)
    {
        parent::__construct($actividadRepository);
        $this->catService = $catService;
    }
    
    public function proximaActividad($conceptoId, $alumnoId) {
        $item = $this->catService->getNextItemFor($conceptoId, $alumnoId);
        return ($item != null) ? $this->getById($item->getCode()) : null;
    }
    
}
