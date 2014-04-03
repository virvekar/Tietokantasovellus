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
    public function getTaidonLisaysPaiva(){
        return $this->taidonlisayspaiva;
    }
    public function getLisaaja(){
        return $this->lisaaja;
    }
   
public static function AnnaTaitoListaus() {
        $sql = "SELECT taidonid, taidonNimi,taidonKuvaus,taidonLisaysPaiva,puuhaajaid FROM taidot";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $taidot = new Taidot();
            $taidot->setId($tulos->taidonid);
            $taidot->setNimi($tulos->taidonnimi);
            $taidot->setKuvaus($tulos->taidonkuvaus);
            $taidot->setTaidonLisaysPaiva($tulos->taidonlisayspaiva);
            $taidot->setLisaaja($tulos->puuhaajaid);

            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $tulokset[] = $taidot;
        }
        return $tulokset;
    }
    
    public static function AnnaTaidonLisaajaListaus() {
        $sql = "SELECT taidonid, taidonNimi,taidonKuvaus,taidonLisaysPaiva,puuhaajaid FROM taidot";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {

            $tulokset[] = $tulos->puuhaajaid;
        }
        return $tulokset;
    }
}
