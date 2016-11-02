<?php
namespace Safe\DocenteBundle\Service;

use Safe\TemaBundle\Repository\ConceptoRepository;

use Safe\TemaBundle\Service\ConceptoService;
use Safe\CatBundle\Service\CatService;
use Safe\CatBundle\Entity\ItemBank;
use Safe\DocenteBundle\Form\ConceptoForm;
use Safe\DocenteBundle\Entity\Estadistica\EstadisticaConceptoAlumno;

use Safe\TemaBundle\Repository\AlumnoEstadoConceptoRepository;

use Doctrine\Common\Util\Debug;
class ConceptoImpartidoService extends ConceptoService {
    
    private $catService;

    private $alumnoEstadoConceptoRepository;
    
    public function __construct(ConceptoRepository $conceptoRepository, 
            AlumnoEstadoConceptoRepository $alumnoEstadoConceptoRepository,
            CatService $catService)
    {
         parent::__construct($conceptoRepository);
         $this->catService = $catService;
         $this->alumnoEstadoConceptoRepository = $alumnoEstadoConceptoRepository;
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
            $itemBank = $this->catService->getItemBankByCode($concepto->getId());
            $ability = $this->catService->getAbility($alumnoId, $concepto->getId());
            $alumnoEstadoConcepto = $this->alumnoEstadoConceptoRepository->findOneBy(array('concepto'=> $concepto, 'alumno' => $alumnoId));
            $estadisticaConceptoAlumno = new EstadisticaConceptoAlumno($concepto, $itemBank, $ability, $alumnoEstadoConcepto);
            $estadisticas[] = $estadisticaConceptoAlumno;
        }
        return $estadisticas;
    }

    
}
