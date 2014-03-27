<?php

class Puuhat {

    private $id;
    private $nimi;
    private $puuhaluokanid;
    private $kuvaus;
    private $kesto;
    private $henkilomaara;
    private $paikka;
    private $ajankohta;
    private $puuhanlisayspaiva;
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
    public function setPuuhaluokanId($puuhaluokanid){
        $this->puuhaluokanid = $puuhaluokanid;
    }
    public function setKesto($kesto){
        $this->kesto = $kesto;
    }
    public function sethenkilomaara($henkilomaara){
        $this->henkilomaara = $henkilomaara;
    }
    public function setPaikka($paikka){
        $this->paikka = $paikka;
    }
    public function setAjankohta($ajankohta){
        $this->ajankohta = $ajankohta;
    }
    public function setPuuhanlisaysPaiva($puuhanlisayspaiva){
        $this->puuhanlisayspaiva = $puuhanlisayspaiva;
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
    public function getPuuhaluokanId(){
        return $this->puuhaluokanid;
    }
    public function getKesto(){
        return $this->kesto;
    }
    public function getHenkilomaara(){
        return $this->henkilomaara;
    }
    public function getPaikka(){
        return $this->paikka;
    }
    public function getAjankohta(){
        return $this->ajankohta;
    }
    public function getPuuhanlisayspaiva(){
        return $this->puuhanlisayspaiva;
    }
    public function getLisaaja(){
        return $this->lisaaja;
    }
    public function getKuvaus(){
        return $this->kuvaus;
    }
    

}

