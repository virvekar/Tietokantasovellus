<?php

class OmatTaidot {

    private $taitoid;
    private $puuhaajaid;


    public function __construct() {
               
    }

    /* Tähän gettereitä ja settereitä */
    public function setTaitoId($taitoid){
        $this->taitoid = $taitoid;
    }
    public function setPuuhaajaId($puuhaajaid){
        $this->puuhaajaid = $puuhaajaid;
    }
    
    public function getTaitoId(){
        return $this->taitoid;
    }
    public function getPuuhaajaId(){
        return $this->puuhaajaid;
    }
    
    /*Luo omatTaidot olion ja antaa sille tuloksissa määritellyt arvot*/
    public static function asetaArvot($tulos){
        $OmatTaidot=new OmatTaidot();
        $OmatTaidot->setTaitoId($tulos->taidonid);
        $OmatTaidot->setPuuhaajaId($tulos->puuhaajaid);
        return $OmatTaidot;
    }

    /*Tallentaa henkilön osaaman taidon tauluun*/
    public function LisaaOmiinTaitoihin(){
        $sql = "INSERT INTO omatTaidot(taidonid, puuhaajaid) VALUES(?,?) RETURNING taidonid";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getTaitoId(), $this->getPuuhaajaId()));
        if ($ok) {
            //Haetaan RETURNING-määreen palauttama id.
            //HUOM! Tämä toimii ainoastaan PostgreSQL-kannalla!
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }
    
    /*Antaa listan taitojen id:stä jotka ovat henkilön omissa taidoissa*/
    public function AnnaKayttajanTaidot($puuhaajaid){
        $sql = "SELECT taidonid, puuhaajaid FROM omatTaidot WHERE puuhaajaid=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($puuhaajaid));
        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {

            $tulokset[] = OmatTaidot::asetaArvot($tulos)->getTaitoId();
        }

        return $tulokset;
    }
    
    /*Poistaa taidon henkilon taidoista*/
    public function PoistaOmistaTaidoista($taidonid,$puuhaajaid){
         $sql = "DELETE FROM omatTaidot WHERE taidonid = ? AND puuhaajaid=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($taidonid,$puuhaajaid));

        return $ok;
    }
}

