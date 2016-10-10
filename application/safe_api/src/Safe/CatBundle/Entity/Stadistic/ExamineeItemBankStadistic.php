<?php
namespace Safe\CatBundle\Entity\Stadistic;

class ExamineeItemBankStadistic {
    private $itemBankCode;
    private $itemsNumbers;
    private $itemsResolved;
    private $itemsResolvedOk;
    private $currentTheta;
    private $pastAbilities;

    function __construct($itemBankCode, $itemsNumbers = 0, $itemsResolved = 0, $itemsResolvedOk = 0, $currentTheta = -9999, $pastAbilities = array()) {
        $this->itemBankCode = $itemBankCode;
        $this->itemsNumbers = $itemsNumbers;
        $this->itemsResolved = $itemsResolved;
        $this->itemsResolvedOk = $itemsResolvedOk;
        $this->currentTheta = $currentTheta;
        $this->pastAbilities = $pastAbilities;
    }

    function getItemBankCode() {
        return $this->itemBankCode;
    }

    function getItemsNumbers() {
        return $this->itemsNumbers;
    }

    function getItemsResolved() {
        return $this->itemsResolved;
    }

    function getItemsResolvedOk() {
        return $this->itemsResolvedOk;
    }

    function getCurrentTheta() {
        return $this->currentTheta;
    }

    function getPastAbilities() {
        return $this->pastAbilities;
    }

    function setItemBankCode($itemBankCode) {
        $this->itemBankCode = $itemBankCode;
    }

    function setItemsNumbers($itemsNumbers) {
        $this->itemsNumbers = $itemsNumbers;
    }

    function setItemsResolved($itemsResolved) {
        $this->itemsResolved = $itemsResolved;
    }

    function setItemsResolvedOk($itemsResolvedOk) {
        $this->itemsResolvedOk = $itemsResolvedOk;
    }

    function setCurrentTheta($currentTheta) {
        $this->currentTheta = $currentTheta;
    }

    function setPastAbilities($pastAbilities) {
        $this->pastAbilities = $pastAbilities;
    }


}
