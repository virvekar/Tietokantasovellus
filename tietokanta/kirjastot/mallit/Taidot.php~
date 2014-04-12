<?php

class Taidot {

    private $id;
    private $nimi;
    private $kuvaus;
    private $taidonlisayspaiva;
    private $lisaaja;
    private $virheet = array();

    public function __construct() {
        
    }

    /* Tähän gettereitä ja settereitä */

    public function setId($id) {
        $this->id = $id;
    }

    public function setNimi($nimi) {
        $this->nimi = $nimi;
        if (trim($this->nimi) == '') {
            $this->virheet['nimi'] = "Nimi ei saa olla tyhjä.";
        } else if (strlen($this->nimi) > 50) {
            $this->virheet['nimi'] = "Nimi on liian pitkä.";
        } else {
            unset($this->virheet['nimi']);
        }
    }

    public function setKuvaus($kuvaus) {
        $this->kuvaus = $kuvaus;
        if (trim($this->kuvaus) == '') {
            $this->virheet['kuvaus'] = "Kuvaus ei saa olla tyhjä.";
        } else if (strlen($this->kuvaus) > 1000) {
            $this->virheet['kuvaus'] = "Kuvaus on liian pitkä.";
        } else {
            unset($this->virheet['kuvaus']);
        }
    }

    public function setTaidonLisaysPaiva($taidonlisayspaiva) {
        $this->taidonlisayspaiva = $taidonlisayspaiva;
    }

    public function setLisaaja($lisaaja) {
        $this->lisaaja = $lisaaja;
    }

    public function getId() {
        return $this->id;
    }

    public function getNimi() {
        return $this->nimi;
    }

    public function getKuvaus() {
        return $this->kuvaus;
    }

    public function getTaidonLisaysPaiva() {
        return $this->taidonlisayspaiva;
    }

    public function getLisaaja() {
        return $this->lisaaja;
    }

    public function getVirheet() {
        return $this->virheet;
    }

    public static function asetaArvot($tulos) {
        $taidot = new Taidot();
        $taidot->setId($tulos->taidonid);
        $taidot->setNimi($tulos->taidonnimi);
        $taidot->setKuvaus($tulos->taidonkuvaus);
        $taidot->setTaidonLisaysPaiva($tulos->taidonlisayspaiva);
        $taidot->setLisaaja($tulos->puuhaajaid);
        
        return $taidot;
    }

    public static function AnnaTaitoListaus() {
        $sql = "SELECT taidonid, taidonNimi,taidonKuvaus,taidonLisaysPaiva,puuhaajaid FROM taidot";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {

            $tulokset[] = Taidot::asetaArvot($tulos);
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

    public static function AnnaTaitoListausRajattu($montako, $sivu) {
        $sql = "SELECT taidonid, taidonNimi,taidonKuvaus,taidonLisaysPaiva,puuhaajaid FROM taidot ORDER BY taidonNimi LIMIT ? OFFSET ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($montako, ((int) $sivu - 1) * $montako));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[] = Taidot::asetaArvot($tulos);
        }
        return $tulokset;
    }

    public static function AnnaTaidonLisaajaListausRajattu($montako, $sivu) {
        $sql = "SELECT taidonid, taidonNimi,taidonKuvaus,taidonLisaysPaiva,puuhaajaid FROM taidot ORDER BY taidonNimi LIMIT ? OFFSET ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($montako, ((int) $sivu - 1) * $montako));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {

            $tulokset[] = $tulos->puuhaajaid;
        }
        return $tulokset;
    }

    public static function AnnaTaidonID($taidonNimi) {
        $sql = "SELECT taidonid FROM taidot WHERE taidonNimi= ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($taidonNimi));


        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        }
        return $tulos->taidonid;
    }
public static function HaeTaidotTekijalla($puuhaajaid) {
        $sql = "SELECT taidonid, taidonNimi,taidonKuvaus,taidonLisaysPaiva,puuhaajaid FROM taidot WHERE puuhaajaid=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($puuhaajaid));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {

            $tulokset[] = Taidot::asetaArvot($tulos);
        }
        return $tulokset;
    }
    
    public static function EtsiTaito($taidonid) {
        $sql = "SELECT taidonid, taidonNimi, taidonKuvaus,taidonLisaysPaiva, puuhaajaid FROM taidot WHERE taidonid= ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($taidonid));
        $tulos = $kysely->fetchObject();
         
        if ($tulos == null) {
           
            return null;
        }
       
        return Taidot::asetaArvot($tulos);
    }
    public static function lukumaara() {
        $sql = "SELECT count(*) FROM taidot";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
        return $kysely->fetchColumn();
    }

    public function lisaaKantaan() {
        $sql = "INSERT INTO Taidot( taidonNimi, taidonKuvaus,taidonLisaysPaiva, puuhaajaid) VALUES(?,?,?,?) RETURNING taidonid";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getNimi(), $this->getKuvaus(), $this->getTaidonLisaysPaiva(), $this->getLisaaja()));
        if ($ok) {
            //Haetaan RETURNING-määreen palauttama id.
            //HUOM! Tämä toimii ainoastaan PostgreSQL-kannalla!
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }
    public function lisaaMuokkauksetKantaan() {
        $sql = "UPDATE Taidot SET taidonNimi=?, taidonKuvaus=?,taidonLisaysPaiva=?, puuhaajaid=?
 WHERE taidonid=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->getNimi(), $this->getKuvaus(), $this->getTaidonLisaysPaiva(), $this->getLisaaja(), $this->getId()));
        error_log(print_r($this->getId(), TRUE)); 
        return $ok;
    }

    public static function PoistaTaito($taidonid) {
        $sql = "DELETE FROM taidot WHERE taidonid = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($taidonid));

        return $ok;
    }

}
