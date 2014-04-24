<?php

require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';


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
    private $virheet = array();
    private $taidot= array();

    public function __construct() {
        
    }

    /* Tähän gettereitä ja settereitä */

    public function setId($id) {
        $this->id = $id;
    }

/*Asettaa puuhalle nimen ja tarkistaa ettei nimi ole tyhjä eikä
Se ole liian pitkä*/
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

/*Asettaa puuhalle kuvauksen ja tarkistaa ettei se ole tyhjä eikä
Se ole liian pitkä*/
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

/*Asettaa puuhaluokalle id:n ja tarkistaa löytyykö se tietokannasta*/
    public function setPuuhaluokanId($puuhaluokanid) {
        $this->puuhaluokanid = $puuhaluokanid;
        if (is_null(Puuhaluokka::AnnaPuuhaLuokka($puuhaluokanid))) {
            $this->virheet['puuhaluokanid'] = "Puuhaluokkaa ei löytynyt tietokannasta";
        } else {
            unset($this->virheet['puuhaluokanid']);
        }
    }

/*Asettaa puuhalle keston ja tarkistaa että se on positiivinen luku*/
    public function setKesto($kesto) {
        $this->kesto = (float)$kesto;
        error_log(print_r($kesto, TRUE)); 
        if (!is_numeric($kesto)) {
            $this->virheet['kesto'] = "Keston tulee olla numero.";
        } else if ($kesto <= 0) {
            $this->virheet['kesto'] = "Puuhalla täytyy olla positiivinen kesto.";
        } else if ($kesto > 9999999) {
            $this->virheet['kesto'] = "Puuhan keston täytyy olla vähemmän kuin 9999999 tuntia.";
        } else {
            unset($this->virheet['kesto']);
        }
    }

/*Asettaa puuhalle henkilomaaran ja tarkistaa että se on positiivinen kokonaisluku*/
    public function setHenkilomaara($henkilomaara) {
        $this->henkilomaara = $henkilomaara;
        if (!is_numeric($henkilomaara)) {
            $this->virheet['henkilomaara'] = "Henkilomaaran tulee olla numero.";
        } else if ($henkilomaara <= 0) {
            $this->virheet['henkilomaara'] = "Henkilomaaran täytyy olla positiivinen henkilomaara.";
        }else if ($henkilomaara >= 1000000) {
            $this->virheet['henkilomaara'] = "Henkilomaaran ei saa olla suurempi kuin 1000000.";
        }else if (!preg_match('/^\d+$/', $henkilomaara)) {
            $this->virheet['henkilomaara'] = "Henkilomaaran tulee olla kokonaisluku.";
        } else {
            unset($this->virheet['henkilomaara']);
        }
    }

/*Asettaa puuhalle paikan ja tarkistaa ettei se ole tyhjä tai liian pitkä merkkijono*/
    public function setPaikka($paikka) {
        $this->paikka = $paikka;
        if (trim($this->paikka) == '') {
            $this->virheet['paikka'] = "Paikka ei saa olla tyhjä.";
        } else if (strlen($this->paikka) > 100) {
            $this->virheet['paikka'] = "Paikan nimi on liian pitkä.";
        } else {
            unset($this->virheet['paikka']);
        }
    }

/*Asettaa ajankohdan ja tarkistaa että se on datetime objekti*/
    public function setAjankohta($ajankohta) {
        $this->ajankohta = $ajankohta;
        if (!is_a($ajankohta, 'DateTime')) {
            $this->virheet['ajankohta'] = "Ajankohta on syötetty väärin.";
        } else {
            unset($this->virheet['ajankohta']);
        }
    }

/*Asettaa ajankohdan ilman mitään tarkistuksia*/
    public function setAjankohtaEiTarkistusta($ajankohta) {
        $this->ajankohta = $ajankohta;
    }

    public function setPuuhanLisaysPaiva($puuhanlisayspaiva) {
        $this->puuhanlisayspaiva = $puuhanlisayspaiva;
    }

     public function setTaidot($taidot) {
     	    if (empty($taidot)){
	        $this->taidot = $taidot;
  	    }else {
	    	  $virheita=0;
            	foreach ($taidot as $taitoid){
		   $taito=Taidot::EtsiTaito($taitoid);
		   if(is_null($taito)){		       
		       $virheita=$virheita+1;
		   }		       
		}
		if($virheita==0){
	 	   unset($this->virheet['taidot']);
 		   $this->taidot = $taidot;
		}else{
		   $this->virheet['taidot'] = "Kaikkia taitoja ei löytynyt tietokannasta.";
		   $this->taidot = array();
		}
	    }
        
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

    public function getPuuhaluokanId() {
        return $this->puuhaluokanid;
    }

    public function getKesto() {
        return $this->kesto;
    }

    public function getHenkilomaara() {
        return $this->henkilomaara;
    }

    public function getPaikka() {
        return $this->paikka;
    }

    public function getAjankohta() {
        return $this->ajankohta;
    }

    public function getPaiva() {


        if (empty($this->ajankohta)) {
            return null;
        }
        $ajankohta = new DateTime($this->ajankohta);

        return $ajankohta->format("j.n.Y");
    }

    public function getKellonaika() {
        if (empty($this->ajankohta)) {
            return null;
        }
         $ajankohta = new DateTime($this->ajankohta);
        return $ajankohta->format("H.i");
    }

    public function getPuuhanLisaysPaiva() {
        return $this->puuhanlisayspaiva;
    }

    public function getLisaaja() {
        return $this->lisaaja;
    }

    public function getKuvaus() {
        return $this->kuvaus;
    }

    public function getPuuhaluokanNimi() {

        return Puuhaluokka::AnnaPuuhaLuokka($this->puuhaluokanid);
    }

    public function getVirheet() {
        return $this->virheet;
    }
    public function getTaidot() {
        return $this->taidot;
    }
    public function getTaidotTeksti(){
        $tekstia="";
	$taitojenNimet=Taidot::EtsiTaitojenNimet($this->taidot);
	foreach($taitojenNimet as  $taidonNimi){
	    $tekstia=$tekstia.$taidonNimi.", ";
        }
	return substr($tekstia,0,strlen($tekstia)-2);
  }

/*Etsii tietokannasta kaikki puuhat tietyssä luokassa*/
    public static function EtsiPuuhatLuokassa($luokanid) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhaluokanid= ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($luokanid));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[] = Puuhat::asetaArvot($tulos);
        }
        return $tulokset;
    }

/*Luo uuden puuhan ja asettaa tulos muuttujassa saadut arvot sille*/
    public static function asetaArvot($tulos){
        $puuha = new Puuhat();
        $puuha->setId($tulos->puuhanid);
        $puuha->setNimi($tulos->puuhannimi);
        $puuha->setKuvaus($tulos->puuhankuvaus);
        $puuha->setPuuhaluokanId($tulos->puuhaluokanid);
        $puuha->setKesto($tulos->puuhankesto);
        $puuha->setHenkilomaara($tulos->henkilomaara);
        $puuha->setPaikka($tulos->paikka);
        $puuha->setAjankohtaEiTarkistusta($tulos->ajankohta);
        $puuha->setPuuhanLisaysPaiva($tulos->puuhanlisayspaiva);
        $puuha->setLisaaja($tulos->puuhaajaid);

        
        return $puuha;
    }

/*Etsii tietokannasta puuhan id:n avulla*/
    public static function EtsiPuuha($puuhanid) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhanid= ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($puuhanid));

        $tulos = $kysely->fetchObject();
        return Puuhat::asetaArvot($tulos);
    }

/*Etsii tietokannasta puuhan nimen avulla*/
    public static function EtsiPuuhaNimella($puuhanNimi) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhanNimi= ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($puuhanNimi));

        $tulos = $kysely->fetchObject();
        return Puuhat::asetaArvot($tulos);
    }

/*Etsii luokassa olevat puuhat ottaen tietylle sivulle tulevan osan puuhista*/
    public static function EtsiPuuhatLuokassaRajattu($luokanid, $montako, $sivu) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhaluokanid= ? ORDER BY puuhanNimi LIMIT ? OFFSET ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($luokanid, $montako, ((int) $sivu - 1) * $montako));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
 
            $tulokset[] = Puuhat::asetaArvot($tulos);
        }
        return $tulokset;
    }

/*Laskee montako puuhaa on tietyssä luokassa*/
    public static function lukumaara($luokanid) {
        $sql = "SELECT count(*) FROM puuhat where puuhaluokanid= ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($luokanid));
        return $kysely->fetchColumn();
    }

/*Hakee tiettyyn luokkaan kuuluvat puuhat keston, henkilömäärän ja paikan perusteella*/
    public static function HaePuuhat($luokanid, $kestoAla, $kestoYla, $henkilomaaraAla, $henkilomaaraYla, $paikka) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhaluokanid= ? AND puuhanKesto>= ? AND puuhanKesto<= ? AND henkilomaara>=? AND henkilomaara<=? AND paikka=?
                ORDER BY puuhanNimi";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($luokanid, $kestoAla, $kestoYla, $henkilomaaraAla, $henkilomaaraYla, $paikka));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
             $tulokset[] = Puuhat::asetaArvot($tulos);
        }
        return $tulokset;
    }

/*Hakee tiettyyn luokkaan kuuluvat puuhat keston ja henkilömäärän perusteella*/
    public static function HaePuuhatEiPaikkaa($luokanid, $kestoAla, $kestoYla, $henkilomaaraAla, $henkilomaaraYla) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhaluokanid= ? AND puuhanKesto>= ? AND puuhanKesto<= ? AND henkilomaara>=? AND henkilomaara<=?
                ORDER BY puuhanNimi";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($luokanid, $kestoAla, $kestoYla, $henkilomaaraAla, $henkilomaaraYla));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[] = Puuhat::asetaArvot($tulos);
        }
        return $tulokset;
    }

/*Hakee puuhia keston ja henkilömäärän perusteella*/
    public static function HaePuuhatEiPaikkaaEiLuokkaa($kestoAla, $kestoYla, $henkilomaaraAla, $henkilomaaraYla) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhanKesto>= ? AND puuhanKesto<= ? AND henkilomaara>=? AND henkilomaara<=?
                ORDER BY puuhanNimi";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kestoAla, $kestoYla, $henkilomaaraAla, $henkilomaaraYla));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
           $tulokset[] = Puuhat::asetaArvot($tulos);
        }
        return $tulokset;
    }

/*Hakee puuhia keston, henkilömäärän ja paikan perusteella*/
    public static function HaePuuhatEiLuokkaa($kestoAla, $kestoYla, $henkilomaaraAla, $henkilomaaraYla, $paikka) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhanKesto>= ? AND puuhanKesto<= ? AND henkilomaara>=? AND henkilomaara<=? AND paikka=?
                ORDER BY puuhanNimi";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kestoAla, $kestoYla, $henkilomaaraAla, $henkilomaaraYla, $paikka));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[] = Puuhat::asetaArvot($tulos);
        }
        return $tulokset;
    }

/*Lisää puuhan kantaan*/
    public function lisaaKantaan() {
        $sql = "INSERT INTO Puuhat(puuhanNimi,puuhaluokanid, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta, puuhanLisaysPaiva, puuhaajaid)
 VALUES(?,?,?,?,?,?,?,?,?) RETURNING puuhanid";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->getNimi(), $this->getPuuhaluokanId(), $this->getKuvaus(), $this->getKesto(),
            $this->getHenkilomaara(), $this->getPaikka(), $this->getAjankohta()->format("Y-m-d H:i:s"), $this->getPuuhanLisaysPaiva(), $this->getLisaaja()));
        if ($ok) {
            //Haetaan RETURNING-määreen palauttama id.
            //HUOM! Tämä toimii ainoastaan PostgreSQL-kannalla!
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }

/*Lisää puuhan tietokantaan siten että ajankohtaa ei aseteta*/
    public function lisaaKantaanEiAikaa() {
        $sql = "INSERT INTO Puuhat(puuhanNimi,puuhaluokanid, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, puuhanLisaysPaiva, puuhaajaid)
 VALUES(?,?,?,?,?,?,?,?) RETURNING puuhanid";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->getNimi(), $this->getPuuhaluokanId(), $this->getKuvaus(), $this->getKesto(),
            $this->getHenkilomaara(), $this->getPaikka(), $this->getPuuhanLisaysPaiva(), $this->getLisaaja()));
        if ($ok) {
            //Haetaan RETURNING-määreen palauttama id.
            //HUOM! Tämä toimii ainoastaan PostgreSQL-kannalla!
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }

/*Tallentaa puuhaan tehdyt muokkaukset tietokantaan*/
    public function lisaaMuokkauksetKantaan() {
        $sql = "UPDATE Puuhat SET puuhanNimi=?, puuhaluokanid=?, puuhanKuvaus=?, puuhanKesto=?, henkilomaara=?, paikka=?, ajankohta=?, puuhanLisaysPaiva=?, puuhaajaid=?
 WHERE puuhanid=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->getNimi(), $this->getPuuhaluokanId(), $this->getKuvaus(), $this->getKesto(),
            $this->getHenkilomaara(), $this->getPaikka(), $this->getAjankohta()->format("Y-m-d H:i:s"), $this->getPuuhanLisaysPaiva(), $this->getLisaaja(), $this->getId()));
        return $ok;
    }

/*Tallentaa puuhaan tehdyt muokkaukset kantaan siten että aikaa ei aseteta*/
    public function lisaaMuokkauksetKantaanEiAikaa() {
        $sql = "UPDATE Puuhat SET puuhanNimi=?, puuhaluokanid=?, puuhanKuvaus=?, puuhanKesto=?, henkilomaara=?, paikka=?, puuhanLisaysPaiva=?, puuhaajaid=?
 WHERE puuhanid=?";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getNimi(), $this->getPuuhaluokanId(), $this->getKuvaus(), $this->getKesto(),
            $this->getHenkilomaara(), $this->getPaikka(), $this->getPuuhanLisaysPaiva(), $this->getLisaaja(), $this->getId()));

        return $ok;
    }

/*Etsii tietyn henkilön lisäämät puuhat*/
    public static function HaePuuhatTekijalla($lisaajaid) {
        $sql = "SELECT puuhanid, puuhaluokanid, puuhanNimi, puuhanKuvaus, puuhanKesto, henkilomaara, paikka, ajankohta,puuhanLisaysPaiva, puuhaajaid FROM puuhat
                where puuhaajaid= ?
                ORDER BY puuhanNimi";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($lisaajaid));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[] = Puuhat::asetaArvot($tulos);
        }
        return $tulokset;
    }

/*Poistaa puuhan*/
    public static function PoistaPuuha($puuhanid) {
        $sql = "DELETE FROM puuhat WHERE puuhanid = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($puuhanid));

        return $ok;
    }
/*Palauttaa true jos henkilön tykkäys löytyy suosikit taulusta*/
    public function OnkoTykannyt($puuhaajaid){
         $sql = "SELECT puuhanid, puuhaajaid FROM Suosikit
                where puuhanid=? AND puuhaajaid= ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($this->getId(), $puuhaajaid));

        $tulos = $kysely->fetchObject();
  
        if(empty($tulos)){
            return FALSE;
        }else{
            return TRUE;
        }
    }

}
