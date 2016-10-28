<?php
namespace Safe\CatBundle\Entity;

class ThetaEstimation {

    private $theta;
    
    private $diff;
    
    private $standarError;
    

    public function __construct($theta=0, $diff=0, $standarError=0)
    {
        $this->theta = $theta;
        $this->diff = $diff;
        $this->standarError = $standarError;
    }
    function getTheta() {
        return $this->theta;
    }

    function getDiff() {
        return $this->diff;
    }

    function getStandarError() {
        return $this->standarError;
    }

    function setTheta($theta) {
        $this->theta = $theta;
    }

    function setDiff($diff) {
        $this->diff = $diff;
    }

    function setStandarError($standarError) {
        $this->standarError = $standarError;
    }


    
    
}
