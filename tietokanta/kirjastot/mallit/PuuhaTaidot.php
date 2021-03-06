<?php

class PuuhaTaidot {

    private $taitoid;
    private $puuhanid;


    public function __construct() {
               
    }

    /* Tähän gettereitä ja settereitä */
    public function setTaitoId($taitoid){
        $this->taitoid = $taitoid;
    }
    public function setPuuhanId($puuhanid){
        $this->puuhanid = $puuhanid;
    }
    
    public function getTaitoId(){
        return $this->taitoid;
    }
    public function getPuuhanId(){
        return $this->puuhanid;
    }

    /*Luo PuuhaTaidot olion ja antaa sille tuloksissa määritellyt arvot*/
    public static function asetaArvot($tulos){
        $puuhaTaito=new PuuhaTaidot();
        $puuhaTaito->setPuuhanId($tulos->puuhanid);
        $puuhaTaito->setTaitoId($tulos->taidonid);
        return $puuhaTaito;
    }
    
    /*Tallentaa taidon puuhan vaatimuksiin*/
    public function LisaaKantaan(){
        $sql = "INSERT INTO puuhaTaidot(puuhanid, taidonid) VALUES(?,?) RETURNING puuhanid";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getPuuhanId(), $this->getTaitoId()));
        if ($ok) {
            //Haetaan RETURNING-määreen palauttama id.
            //HUOM! Tämä toimii ainoastaan PostgreSQL-kannalla!
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }
    /*Antaa listan taitojen id:sta jotka kuuluvat puuhaan*/
    public function AnnaPuuhanTaidot($puuhanid){
        $sql = "SELECT puuhanid, taidonid FROM puuhaTaidot WHERE puuhanid=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($puuhanid));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {

            $tulokset[] = PuuhaTaidot::asetaArvot($tulos)->getTaitoId();
        }

        return $tulokset;
    }
    
    /*Poistaa taidon puuhan vaatimuksista*/
    public function PoistaPuuhaTaito($puuhanid,$taidonid){
         $sql = "DELETE FROM puuhaTaidot WHERE puuhanid = ? AND taidonid=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($puuhanid,$taidonid));

        return $ok;
    }

 /*Poistaa taidot puuhan vaatimuksista*/
    public function PoistaPuuhaTaidot($puuhanid,$taidonidLista){
         foreach($taidonidLista as $taitoid){
	     PuuhaTaidot::PoistaPuuhaTaito($puuhanid,$taitoid);
    }
 }
}


