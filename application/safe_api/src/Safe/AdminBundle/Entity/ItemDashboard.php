<?php

namespace Safe\AdminBundle\Entity;

class ItemDashboard
{
    private $total;
    private $parcial;

    
    function getTotal() {
        return $this->total;
    }

    function getParcial() {
        return $this->parcial;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setParcial($parcial) {
        $this->parcial = $parcial;
    }


}
