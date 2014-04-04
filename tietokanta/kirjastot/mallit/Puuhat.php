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
    public function setHenkilomaara($henkilomaara){
        $this->henkilomaara = $henkilomaara;
    }
    public function setPaikka($paikka){
        $this->paikka = $paikka;
    }
    public function setAjankohta($ajankohta){
        $this->ajankohta = $ajankohta;
    }
    public function setPuuhanLisaysPaiva($puuhanlisayspaiva){
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
    public function getPuuhanLisaysPaiva(){
        return $this->puuhanlisayspaiva;
    }
    public function getLisaaja(){
        return $this->lisaaja;
    }
    public function getKuvaus(){
        return $this->kuvaus;
    }
    
     public static function EtsiPuuhatLuokassa($luokanid) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhaluokanid= ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($luokanid));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $puuha = new Puuhat();
            $puuha->setId($tulos->puuhanid);
            $puuha->setNimi($tulos->puuhannimi);
            $puuha->setKuvaus($tulos->puuhankuvaus);
            $puuha->setPuuhaluokanId($tulos->puuhanluokanid);
            $puuha->setKesto($tulos->puuhankesto);
            $puuha->setHenkilomaara($tulos->henkilomaara);
            $puuha->setPaikka($tulos->paikka);
            $puuha->setAjankohta($tulos->ajankohta);
            $puuha->setPuuhanLisaysPaiva($tulos->puuhanlisayspaiva); 
            $puuha->setLisaaja($tulos->puuhaajaid);
            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $tulokset[] = $puuha;
        }
        return $tulokset;
    }
    public static function EtsiPuuha($puuhanid) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhanid= ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($puuhanid));

        $tulos=$kysely->fetchObject();
            $puuha = new Puuhat();
            $puuha->setId($tulos->puuhanid);
            $puuha->setNimi($tulos->puuhannimi);
            $puuha->setKuvaus($tulos->puuhankuvaus);
            $puuha->setPuuhaluokanId($tulos->puuhaluokanid);
            $puuha->setKesto($tulos->puuhankesto);
            $puuha->setHenkilomaara($tulos->henkilomaara);
            $puuha->setPaikka($tulos->paikka);
            $puuha->setAjankohta($tulos->ajankohta);
            $puuha->setPuuhanLisaysPaiva($tulos->puuhanlisayspaiva); 
            $puuha->setLisaaja($tulos->puuhaajaid);
            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
                  
        return $puuha;
    }
public static function EtsiPuuhatLuokassaRajattu($luokanid,$montako, $sivu) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhaluokanid= ? ORDER BY puuhanNimi LIMIT ? OFFSET ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($luokanid,$montako, ((int) $sivu - 1) * $montako));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $puuha = new Puuhat();
            $puuha->setId($tulos->puuhanid);
            $puuha->setNimi($tulos->puuhannimi);
            $puuha->setKuvaus($tulos->puuhankuvaus);
            $puuha->setPuuhaluokanId($tulos->puuhanluokanid);
            $puuha->setKesto($tulos->puuhankesto);
            $puuha->setHenkilomaara($tulos->henkilomaara);
            $puuha->setPaikka($tulos->paikka);
            $puuha->setAjankohta($tulos->ajankohta);
            $puuha->setPuuhanLisaysPaiva($tulos->puuhanlisayspaiva); 
            $puuha->setLisaaja($tulos->puuhaajaid);
            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $tulokset[] = $puuha;
        }
        return $tulokset;
    }
     public static function lukumaara($luokanid) {
        $sql = "SELECT count(*) FROM puuhat where puuhaluokanid= ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($luokanid));
        return $kysely->fetchColumn();
    }
    public static function HaePuuhat($luokanid,$kestoAla,$kestoYla, $henkilomaaraAla,$henkilomaaraYla,$paikka) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhaluokanid= ? AND puuhanKesto>= ? AND puuhanKesto<= ? AND henkilomaara>=? AND henkilomaara<=? AND paikka=?
                ORDER BY puuhanNimi";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($luokanid,$kestoAla,$kestoYla,$henkilomaaraAla,$henkilomaaraYla,$paikka));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $puuha = new Puuhat();
            $puuha->setId($tulos->puuhanid);
            $puuha->setNimi($tulos->puuhannimi);
            $puuha->setKuvaus($tulos->puuhankuvaus);
            $puuha->setPuuhaluokanId($tulos->puuhanluokanid);
            $puuha->setKesto($tulos->puuhankesto);
            $puuha->setHenkilomaara($tulos->henkilomaara);
            $puuha->setPaikka($tulos->paikka);
            $puuha->setAjankohta($tulos->ajankohta);
            $puuha->setPuuhanLisaysPaiva($tulos->puuhanlisayspaiva); 
            $puuha->setLisaaja($tulos->puuhaajaid);
            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $tulokset[] = $puuha;
        }
        return $tulokset;
    }
        public static function HaePuuhatEiPaikkaa($luokanid,$kestoAla,$kestoYla, $henkilomaaraAla,$henkilomaaraYla) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhaluokanid= ? AND puuhanKesto>= ? AND puuhanKesto<= ? AND henkilomaara>=? AND henkilomaara<=?
                ORDER BY puuhanNimi";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($luokanid,$kestoAla,$kestoYla,$henkilomaaraAla,$henkilomaaraYla));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $puuha = new Puuhat();
            $puuha->setId($tulos->puuhanid);
            $puuha->setNimi($tulos->puuhannimi);
            $puuha->setKuvaus($tulos->puuhankuvaus);
            $puuha->setPuuhaluokanId($tulos->puuhanluokanid);
            $puuha->setKesto($tulos->puuhankesto);
            $puuha->setHenkilomaara($tulos->henkilomaara);
            $puuha->setPaikka($tulos->paikka);
            $puuha->setAjankohta($tulos->ajankohta);
            $puuha->setPuuhanLisaysPaiva($tulos->puuhanlisayspaiva); 
            $puuha->setLisaaja($tulos->puuhaajaid);
            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $tulokset[] = $puuha;
        }
        return $tulokset;
    }
    public static function HaePuuhatEiPaikkaaEiLuokkaa($kestoAla,$kestoYla, $henkilomaaraAla,$henkilomaaraYla) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhanKesto>= ? AND puuhanKesto<= ? AND henkilomaara>=? AND henkilomaara<=?
                ORDER BY puuhanNimi";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kestoAla,$kestoYla,$henkilomaaraAla,$henkilomaaraYla));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $puuha = new Puuhat();
            $puuha->setId($tulos->puuhanid);
            $puuha->setNimi($tulos->puuhannimi);
            $puuha->setKuvaus($tulos->puuhankuvaus);
            $puuha->setPuuhaluokanId($tulos->puuhanluokanid);
            $puuha->setKesto($tulos->puuhankesto);
            $puuha->setHenkilomaara($tulos->henkilomaara);
            $puuha->setPaikka($tulos->paikka);
            $puuha->setAjankohta($tulos->ajankohta);
            $puuha->setPuuhanLisaysPaiva($tulos->puuhanlisayspaiva); 
            $puuha->setLisaaja($tulos->puuhaajaid);
            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $tulokset[] = $puuha;
        }
        return $tulokset;
    }
     public static function HaePuuhatEiLuokkaa($kestoAla,$kestoYla, $henkilomaaraAla,$henkilomaaraYla,$paikka) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhanKesto>= ? AND puuhanKesto<= ? AND henkilomaara>=? AND henkilomaara<=? AND paikka=?
                ORDER BY puuhanNimi";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kestoAla,$kestoYla,$henkilomaaraAla,$henkilomaaraYla,$paikka));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $puuha = new Puuhat();
            $puuha->setId($tulos->puuhanid);
            $puuha->setNimi($tulos->puuhannimi);
            $puuha->setKuvaus($tulos->puuhankuvaus);
            $puuha->setPuuhaluokanId($tulos->puuhanluokanid);
            $puuha->setKesto($tulos->puuhankesto);
            $puuha->setHenkilomaara($tulos->henkilomaara);
            $puuha->setPaikka($tulos->paikka);
            $puuha->setAjankohta($tulos->ajankohta);
            $puuha->setPuuhanLisaysPaiva($tulos->puuhanlisayspaiva); 
            $puuha->setLisaaja($tulos->puuhaajaid);
            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $tulokset[] = $puuha;
        }
        return $tulokset;
    }
}

