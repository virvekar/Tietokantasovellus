<?php

class Puuhaluokka {

    private $id;
    private $nimi;
    private $kuvaus;


    public function __construct() {
               
    }

    /* Tähän gettereitä ja settereitä */
    public function setId($id){
        $this->id = $id;
    }
    public function setNimi($nimi){
        $this->nimi = $nimi;
    }
    public function setKuvaus($kuvaus){
        $this->kuvaus = $kuvaus;
    }

    
    public function getId(){
        return $this->id;
    }
    public function getNimi(){
        return $this->nimi;
    }
    public function getKuvaus(){
        return $this->kuvaus;
    }
    

}
