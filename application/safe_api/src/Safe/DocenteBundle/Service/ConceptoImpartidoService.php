<?php
namespace Safe\DocenteBundle\Service;

use Safe\TemaBundle\Repository\ConceptoRepository;

use Safe\TemaBundle\Service\ConceptoService;
use Safe\CatBundle\Service\CatService;
use Safe\CatBundle\Entity\ItemBank;
use Safe\DocenteBundle\Form\ConceptoForm;

use Doctrine\Common\Util\Debug;
class ConceptoImpartidoService extends ConceptoService {
    
    private $catService;

    public function __construct(ConceptoRepository $conceptoRepository, CatService $catService)
    {
         parent::__construct($conceptoRepository);
         $this->catService = $catService;
    }
    
    public function getById($conceptoId) {
        $concepto = parent::getById($conceptoId);
        $itemBank = $this->catService->getItemBankByCode($concepto->getId());
        $concepto->setItemBank($itemBank);        
        return $concepto;
    }
    /*
    public function crearConcepto($concepto) {        
        $this->conceptoRepository->crearOActualizar($concepto);
        return $concepto;
    }
      
    public function actualizarConcepto(ConceptoForm $conceptoForm) {
        $concepto = $conceptoForm->$conceptoForm->getConcepto();
        $item = $actividad->getItem();
        $item = $this->actualizarEntidadItem($item, $actividadArray);
        
        $this->actividadRepository->crearOActualizar($actividad);
        return $actividad;
    }*/

    
}
