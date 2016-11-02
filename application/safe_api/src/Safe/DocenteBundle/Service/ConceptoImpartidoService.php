<?php
namespace Safe\DocenteBundle\Service;

use Safe\TemaBundle\Repository\ConceptoRepository;

use Safe\TemaBundle\Service\ConceptoService;
use Safe\CatBundle\Service\CatService;
use Safe\CatBundle\Entity\ItemBank;
use Safe\DocenteBundle\Form\ConceptoForm;
use Safe\DocenteBundle\Entity\Estadistica\EstadisticaConceptoAlumno;
use Safe\DocenteBundle\Entity\Estadistica\EstadisticaResultadoActividadAlumno;

use Safe\TemaBundle\Repository\AlumnoEstadoConceptoRepository;
use Safe\DocenteBundle\Service\ActividadImpartidaService;
use Doctrine\Common\Util\Debug;
class ConceptoImpartidoService extends ConceptoService {
    
    private $catService;

    private $alumnoEstadoConceptoRepository;
    
    private $actividadImpartidaService;
    
    public function __construct(ConceptoRepository $conceptoRepository, 
            AlumnoEstadoConceptoRepository $alumnoEstadoConceptoRepository,
            ActividadImpartidaService $actividadImpartidaService,
            CatService $catService)
    {
         parent::__construct($conceptoRepository);
         $this->catService = $catService;
         $this->alumnoEstadoConceptoRepository = $alumnoEstadoConceptoRepository;
         $this->actividadImpartidaService = $actividadImpartidaService;
    }
    
    public function getById($conceptoId) {
        $concepto = parent::getById($conceptoId);
        $itemBank = $this->catService->getItemBankByCode($concepto->getId());
        $concepto->setItemBank($itemBank);        
        return $concepto;
    }
    
    public function getEstadisticaAlumno($temaId, $alumnoId) {
        $conceptos = $this->findAll($temaId, null);
        $estadisticas = array();
        foreach ($conceptos as $concepto) {                        
            $estadisticas[] = $this->getEstadisticaConceptoAlumno($concepto, $alumnoId);
        }
        return $estadisticas;
    }
    
    public function getEstadisticaConceptoFullAlumno($conceptoId, $alumnoId) {
        $concepto = $this->getById($conceptoId);
        $estadistica = $this->getEstadisticaConceptoAlumno($concepto, $alumnoId, true);
        
        $itemsResultados = $this->catService->getItemResults($conceptoId, $alumnoId);
        
        $resultados = array();
        foreach ($itemsResultados as $itemResult) {
            $actividad = $this->actividadImpartidaService->getById($itemResult->getItem()->getCode());
            $resultados[] = new EstadisticaResultadoActividadAlumno($actividad, $itemResult);
        }      
        $estadistica->setResultados($resultados);
        return $estadistica;
    }
    
    private function getEstadisticaConceptoAlumno($concepto, $alumnoId, $completo = false) {
        $itemBank = $this->catService->getItemBankByCode($concepto->getId());
        $ability = $this->catService->getAbility($alumnoId, $concepto->getId());
        $alumnoEstadoConcepto = $this->alumnoEstadoConceptoRepository->findOneBy(array('concepto'=> $concepto, 'alumno' => $alumnoId));
        return new EstadisticaConceptoAlumno($concepto, $itemBank, $ability, $alumnoEstadoConcepto, array(), $completo);        
    }

    
}
