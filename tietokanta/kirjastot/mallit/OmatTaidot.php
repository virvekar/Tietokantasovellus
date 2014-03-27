<?php

class OmatTaidot {

    private $taitoid;
    private $puuhaajaid;


    public function __construct() {
               
    }

    /* Tähän gettereitä ja settereitä */
    public function setTaitoId($taitoid){
        $this->taitoid = $taitoid;
    }
    public function setPuuhaajaId($puuhaajaid){
        $this->puuhaajaid = $puuhaajaid;
    }
    
    public function getTaitoId(){
        return $this->taitoid;
    }
    public function getPuuhaajaId(){
        return $this->puuhaajaid;
    }

}

