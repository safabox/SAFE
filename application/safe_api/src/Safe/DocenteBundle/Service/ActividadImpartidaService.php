<?php
namespace Safe\DocenteBundle\Service;


use Safe\TemaBundle\Service\ActividadService;

use Safe\CatBundle\Service\CatService;
use Safe\CatBundle\Entity\Item;
use Safe\TemaBundle\Repository\ActividadRepository;
use Safe\TemaBundle\Entity\Actividad;

class ActividadImpartidaService extends ActividadService {

    private $catService;
    
    public function __construct(ActividadRepository $actividadRepository, CatService $catService)
    {
         parent::__construct($actividadRepository);
         $this->catService = $catService;
    }

    public function getById($actividadId) {
        $actividad = parent::getById($actividadId);
        $item = $this->catService->getItemByCode($actividad->getId());
        $actividad->setItem($item);
        return $actividad;
    }
    
    public function crearActividad($actividadArray, $concepto) {
        $actividad = new Actividad($actividadArray['titulo'], $actividadArray['ejercicio'], $actividadArray['resultado'], $actividadArray['descripcion'], $this->getBoolean($actividadArray['habilitado']));
        $actividad->setConcepto($concepto);  
        $item = $this->crearItem($actividadArray, $concepto);
        $actividad->setItem($item);
        $this->actividadRepository->crearOActualizar($actividad);
        return $actividad;
    }
      
    public function actualizarActividad($actividadArray, $actividad) {
        $actividad = $this->actualizarEntidadActividad($actividad, $actividadArray);
        $item = $actividad->getItem();
        $item = $this->actualizarEntidadItem($item, $actividadArray);
        
        $this->actividadRepository->crearOActualizar($actividad);
        return $actividad;
    }
    
    private function crearItem($actividadArray, $concepto) {
       $item = new Item();
       $itemBank = $this->catService->getItemBankByCode($concepto->getId());
       if(array_key_exists('dificultad', $actividadArray)) {
           $item->setB($actividadArray['dificultad']);
       }
       if(array_key_exists('discriminador', $actividadArray)) {
           $item->setA($actividadArray['discriminador']);
       }
       if(array_key_exists('azar', $actividadArray)) {
           $item->setC($actividadArray['azar']);
       }
       if(array_key_exists('d', $actividadArray)) {
           $item->setD($actividadArray['d']);
       }
       $item->setItemBank($itemBank);
       return $item;       
    }
 
    private function actualizarEntidadActividad($actividad, $actividadArray) {
        $actividad->setTitulo($actividadArray['titulo']);
        $actividad->setEjercicio($actividadArray['ejercicio']);
        $actividad->setResultado($actividadArray['resultado']);
        $actividad->setDescripcion($actividadArray['descripcion']);
        $actividad->setHabilitado($this->getBoolean($actividadArray['habilitado']));
        return $actividad;
    }
    
    private function actualizarEntidadItem($item, $actividadArray) {
        $item->setB($actividadArray['dificultad']);
        $item->setA($actividadArray['discriminador']);
        $item->setC($actividadArray['azar']);
        $item->setD($this->getBoolean($actividadArray['d']));
        return $item;
    }
    
    
    private function getBoolean($value) {
         return (true === $value || 1 === (int) $value || 'true' === $value || 'TRUE' === $value);
    }
}
