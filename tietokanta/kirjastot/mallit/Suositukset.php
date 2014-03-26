<?php

class Suositukset {

    private $puuhaid;
    private $puuhaajaid;
    private $suositusid;
    private $suositusteksti;


    public function __construct() {
               
    }

    /* Tähän gettereitä ja settereitä */
    public function setPuuhaId($puuhaid){
        $this->puuhaid = $puuhaid;
    }
    public function setPuuhaajaId($puuhaajaid){
        $this->puuhaajaid = $puuhaajaid;
    }
    public function setSuositusId($suositusid){
        $this->suositusid = $suositusid;
    }
    public function setSuositusTeksti($suositusteksti){
        $this->suositusteksti = $suositusteksti;
    }
    
    public function getPuuhaId(){
        return $this->puuhaid;
    }
    public function getPuuhaajaId(){
        return $this->puuhaajaid;
    }
    public function getSuositusId(){
        return $this->suositusid;
    }
    public function getSuositusTeksti(){
        return $this->suositusteksti;
    }
}

