<?php
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';

class Suositukset {

    private $puuhaid;
    private $puuhaajaid;
    private $suositusid;
    private $suositusteksti;
    private $virheet = array();


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
 	if (trim($this->suositusteksti) == '') {
            $this->virheet['suositusteksti'] = "Suositus ei saa olla tyhjä.";
        } else if (strlen($this->suositusteksti) > 1000) {
            $this->virheet['suositusteksti'] = "Suositus on liian pitkä.";
        } else {
            unset($this->virheet['suositusteksti']);
        }
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
    public function getVirheet() {
        return $this->virheet;
    }

public function getSuosittelija(){
       return Henkilo::EtsiHenkilo($this->puuhaajaid);
}

/*Luo suositus olion ja antaa sille tuloksissa määritellyt arvot*/
    public static function asetaArvot($tulos){
        $suositus=new Suositukset();
        $suositus->setPuuhaId($tulos->puuhanid);
        $suositus->setPuuhaajaId($tulos->puuhaajaid);
        $suositus->setSuositusId($tulos->suositusid);
        $suositus->setSuositusTeksti($tulos->suositusteksti);
        return $suositus;
    }

/*Tallentaa suosituksen suositukset tauluun*/
    public function LisaaSuositus(){
        $sql = "INSERT INTO suositukset(puuhanid, puuhaajaid,suositusteksti) VALUES(?,?,?) RETURNING suositusid";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getPuuhaId(), $this->getPuuhaajaId(),$this->getSuositusTeksti()));
        if ($ok) {
            //Haetaan RETURNING-määreen palauttama id.
            //HUOM! Tämä toimii ainoastaan PostgreSQL-kannalla!
            $this->suositusid = $kysely->fetchColumn();
        }
        return $ok;
    }

/*Antaa puuhan suositukset*/
    public function AnnaSuositukset($puuhanid){
        $sql = "SELECT puuhanid, puuhaajaid, suositusteksti, suositusid FROM suositukset WHERE puuhanid=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($puuhanid));
     
        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {

            $tulokset[] = Suositukset::asetaArvot($tulos);
        }
     
        return $tulokset;
    }

/*Antaa suosituksen tiedot*/
    public function EtsiSuositus($suositusid){
        $sql = "SELECT puuhanid, puuhaajaid, suositusteksti, suositusid FROM suositukset WHERE suositusid=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($suositusid));
         foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {

            $tulokset = Suositukset::asetaArvot($tulos);
        }
        return $tulokset;
    }

/*Poistaa puuhan suosituksista*/
    public function PoistaSuositus($suositusid){
         $sql = "DELETE FROM suositukset WHERE suositusid = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($suositusid));

        return $ok;
    }
/*Lisää suositukseen tehdyt muokkaukset kantaan*/
    public function lisaaMuokkauksetKantaan() {
        $sql = "UPDATE suositukset SET puuhanid=?, puuhaajaid=?, suositusteksti=?
 WHERE suositusid=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        error_log(print_r(array($this->getPuuhaId(), $this->getPuuhaajaId(), $this->getSuositusTeksti(), $this->getSuositusId()), TRUE)); 
        $ok = $kysely->execute(array($this->getPuuhaId(), $this->getPuuhaajaId(), $this->getSuositusTeksti(), $this->getSuositusId()));
        return $ok;
    }

}

