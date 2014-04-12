<?php

class Suosikit {

    private $puuhaid;
    private $puuhaajaid;


    public function __construct() {
               
    }

    /* Tähän gettereitä ja settereitä */
    public function setPuuhaId($puuhaid){
        $this->puuhaid = $puuhaid;
    }
    public function setPuuhaajaId($puuhaajaid){
        $this->puuhaajaid = $puuhaajaid;
    }
    
    public function getPuuhaId(){
        return $this->puuhaid;
    }
    public function getPuuhaajaId(){
        return $this->puuhaajaid;
    }
    
    public static function asetaArvot($tulos){
        $suosikit=new Suosikit();
        $suosikit->setPuuhaId($tulos->puuhanid);
        $suosikit->setPuuhaajaId($tulos->puuhaajaid);
        return $suosikit;
    }
    public function LisaaSuosikkeihin(){
        $sql = "INSERT INTO suosikit(puuhanid, puuhaajaid) VALUES(?,?) RETURNING puuhanid";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getPuuhaId(), $this->getPuuhaajaId()));
        if ($ok) {
            //Haetaan RETURNING-määreen palauttama id.
            //HUOM! Tämä toimii ainoastaan PostgreSQL-kannalla!
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }
    public function AnnaKayttajanSuosikit($puuhaajaid){
        $sql = "SELECT puuhanid, puuhaajaid FROM suosikit WHERE puuhaajaid=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($puuhaajaid));
        $kysely->rowCount();
        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {

            $tulokset[] = Suosikit::asetaArvot($tulos)->getPuuhaId();
        }
        error_log(print_r($kysely->rowCount(), TRUE)); 
        return $tulokset;
    }
    public function PoistaSuosikeista($puuhanid,$puuhaajaid){
         $sql = "DELETE FROM suosikit WHERE puuhanid = ? AND puuhaajaid=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($puuhanid,$puuhaajaid));

        return $ok;
    }

}

