<?php

class Taidot {

    private $id;
    private $nimi;
    private $kuvaus;
    private $taidonlisayspaiva;
    private $lisaaja;


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
    public function setTaidonLisaysPaiva($taidonlisayspaiva){
        $this->taidonlisayspaiva = $taidonlisayspaiva;
    }
    public function setLisaaja($lisaaja){
        $this->lisaaja = $lisaaja;
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
    public function getTaidonlisayspPaiva(){
        return $this->taidonlisayspaiva;
    }
    public function getLisaaja(){
        return $this->lisaaja;
    }
   

}
