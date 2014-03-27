<?php

class Henkilo {

    private $id;
    private $tunnus;
    private $salasana;

    public function __construct() {
               
    }

    /* Tähän gettereitä ja settereitä */
    public function setId($id){
        $this->id = $id;
    }
    public function setTunnus($tunnus){
        $this->tunnus = $tunnus;
    }
    public function setSalasana($salasana){
        $this->salasana = $salasana;
    }
    
    public function getId(){
        return $this->id;
    }
    public function getTunnus(){
        return $this->tunnus;
    }
    public function getSalasana(){
        return $this->salasana;
    }
    public function __toString() {
           // return "PuuhaajaID: "+ getId()+" Nimimerkki: "+getTunnus()+" Salasana: "+getSalasana()+"\n";
            return "Puuhaja ID: {$this->id}, Nimimerkki: {$this->tunnus}, Salasana {$this->salasana}\n";
    }
    
    public static function etsiKaikkiKayttajat() {
        $sql = "SELECT puuhaajaid,nimimerkki, salasana FROM henkilo";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $kayttaja = new Henkilo();
            $kayttaja->setId($tulos->puuhaajaid);
            $kayttaja->setTunnus($tulos->nimimerkki);
            $kayttaja->setSalasana($tulos->salasana);

            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $tulokset[] = $kayttaja;
        }
        return $tulokset;
    }


}
