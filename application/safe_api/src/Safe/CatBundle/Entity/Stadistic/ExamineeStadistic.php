<?php
namespace Safe\CatBundle\Entity\Stadistic;

use Safe\CatBundle\Entity\Stadistic\ExamineeItemBankStadistic;

class ExamineeStadistic {

    private $code;
    private $itemBankStadisticList;
    
    public function __construct($code, $itemBankStadisticList = array()) {
        $this->code = $code;
        $this->itemBankStadisticList = $itemBankStadisticList;
    }
    
    public function addItemBankStadistic(ExamineeItemBankStadistic $examineeItemBankStadistic) {
        $this->itemBankStadisticList[] = $examineeItemBankStadistic;
    }
    
    function getCode() {
        return $this->code;
    }

    function getItemBankStadisticList() {
        return $this->itemBankStadisticList;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setItemBankStadisticList($itemBankStadisticList) {
        $this->itemBankStadisticList = $itemBankStadisticList;
    }



}
