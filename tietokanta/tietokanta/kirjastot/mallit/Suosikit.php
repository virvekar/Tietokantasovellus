<?php

class Suosikit {

    private $puuhaid;
    private $puuhaajaid;


    public function __construct() {
               
    }

    /* Tähän gettereitä ja settereitä */
    public function setPuuhaId($puuhaid){
        $this->puuhaid = $puuhaid;
    }
    public function setPuuhaajaId($puuhaajaid){
        $this->puuhaajaid = $puuhaajaid;
    }
    
    public function getPuuhaId(){
        return $this->puuhaid;
    }
    public function getPuuhaajaId(){
        return $this->puuhaajaid;
    }

}

