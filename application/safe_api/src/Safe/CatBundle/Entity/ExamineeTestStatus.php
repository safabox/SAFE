<?php

namespace Safe\CatBundle\Entity;

class ExamineeTestStatus {
    const APPROVED = 'APPROVED';
    const APPROVED_WITH_ERROR = 'APPROVED_WITH_ERROR';
    const FAIL = 'FAIL';
    
    private $status;
        
    private $estimatedError;
    
    private $discretIncrement;
    
    function __construct($status, $estimatedError = 99, $discretIncrement = 0.25) {
        $this->status = $status;
        $this->estimatedError = $estimatedError;
        $this->discretIncrement = $discretIncrement;
    }

    function getStatus() {
        return $this->status;
    }

    function getEstimatedError() {
        return $this->estimatedError;
    }

    function getDiscretIncrement() {
        return $this->discretIncrement;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setEstimatedError($estimatedError) {
        $this->estimatedError = $estimatedError;
    }

    function setDiscretIncrement($discretIncrement) {
        $this->discretIncrement = $discretIncrement;
    }


}
