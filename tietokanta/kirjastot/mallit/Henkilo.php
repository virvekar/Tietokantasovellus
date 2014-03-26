<?php

class Henkilo {

    private $id;
    private $nimimerkki;
    private $salasana;
    private $sahkoposti;
    private $liittymispaiva;
    private $asema;

    public function __construct() {
               
    }

    /* Tähän gettereitä ja settereitä */
    public function setId($id){
        $this->id = $id;
    }
    public function setNimimerkki($tunnus){
        $this->nimimerkki = $tunnus;
    }
    public function setSalasana($salasana){
        $this->salasana = $salasana;
    }
     public function setSahkoposti($sahkoposti){
        $this->sahkoposti = $sahkoposti;
    }
    public function setLiittymispaiva($liittymispaiva){
        return $this->liittymispaiva=$liittymispaiva;
    }
    public function setAsema($asema){
        return $this->asema=$asema;
    }
    
    public function getId(){
        return $this->id;
    }
    public function getNimimerkki(){
        return $this->nimimerkki;
    }
    public function getSalasana(){
        return $this->salasana;
    }
    public function getSahkoposti(){
        return $this->sahkoposti;
    }
     public function getLiittymispaiva(){
        return $this->liittymispaiva;
    }
    public function getAsema(){
        return $this->asema;
    }
    public function __toString() {
           // return "PuuhaajaID: "+ getId()+" Nimimerkki: "+getTunnus()+" Salasana: "+getSalasana()+"\n";
            return "Puuhaja ID: {$this->id}, Nimimerkki: {$this->nimimerkki}, Salasana {$this->salasana}\n";
    }
    
    public static function etsiKaikkiKayttajat() {
        $sql = "SELECT puuhaajaid,nimimerkki, salasana FROM henkilo";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $kayttaja = new Henkilo();
            $kayttaja->setId($tulos->puuhaajaid);
            $kayttaja->setNimimerkki($tulos->nimimerkki);
            $kayttaja->setSalasana($tulos->salasana);

            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $tulokset[] = $kayttaja;
        }
        return $tulokset;
    }
     /* Etsitään kannasta käyttäjätunnuksella ja salasanalla käyttäjäriviä */
  public static function etsiKayttajaTunnuksilla($kayttaja, $salasana) {
    $sql = "SELECT puuhaajaid,sahkoposti,salasana from henkilo where sahkoposti = ? AND salasana = ? LIMIT 1";
    $kysely = getTietokantayhteys()->prepare($sql);
    $kysely->execute(array($kayttaja, $salasana));

    $tulos = $kysely->fetchObject();
    if ($tulos == null) {
      return null;
    } else {
      $kayttaja = new Henkilo(); 
      $kayttaja->setId($tulos->puuhaajaid);
      $kayttaja->setSahkoposti($tulos->sahkoposti);
      $kayttaja->setSalasana($tulos->salasana);

      return $kayttaja;
    }
  }
}
