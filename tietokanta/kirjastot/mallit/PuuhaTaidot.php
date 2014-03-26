<?php

class PuuhaTaidot {

    private $taitoid;
    private $puuhaaid;


    public function __construct() {
               
    }

    /* Tähän gettereitä ja settereitä */
    public function setTaitoId($taitoid){
        $this->taitoid = $taitoid;
    }
    public function setPuuhaaId($puuhaaid){
        $this->puuhaaid = $puuhaaid;
    }
    
    public function getTaitoId(){
        return $this->taitoid;
    }
    public function getPuuhaaId(){
        return $this->puuhaaid;
    }

}


