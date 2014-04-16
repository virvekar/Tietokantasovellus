<?php

class Henkilo {

    private $id;
    private $nimimerkki;
    private $salasana;
    private $sahkoposti;
    private $liittymispaiva;
    private $asema;
    private $virheet = array();

    public function __construct() {
        
    }

    /* Tähän gettereitä ja settereitä */

    public function setId($id) {
        $this->id = $id;
    }

    public function setNimimerkki($tunnus) {
        $this->nimimerkki = $tunnus;
        if (trim($this->nimimerkki) == '') {
            $this->virheet['nimi'] = "Nimimerkki ei saa olla tyhjä.";
        } else if (strlen($this->nimimerkki) > 50) {
            $this->virheet['nimi'] = "Nimimerkki on liian pitkä.";
        } else {
            unset($this->virheet['nimi']);
        }
    }

    public function setSalasana($salasana1, $salasana2) {

        if (trim($salasana1) == '') {
            $this->virheet['salasana'] = "Salasana ei saa olla tyhjä.";
        } else if (trim($salasana2) == '') {
            $this->virheet['salasana'] = "Anna salasana molempiin kenttiin.";
        } else {
            unset($this->virheet['salasana']);
            $salasanaHash = $this->vertaaSalasanojaJaAnnaHash($salasana1, $salasana2);

            if (is_null($salasanaHash)) {
                $this->virheet['salasana'] = "Salasanat eivat vastanneet toisiaan.";
            } else {
                $this->salasana = substr($salasanaHash, 0, 19);
                unset($this->virheet['salasana']);
            }
        }
    }
    public function setSalasana2($salasana1){
        $this->salasana=$salasana1;
    }

    /* tarkistaa ovatko annetut salasanat samat ja palauttaa hashin talletettavaksi
      tietokantaan */

    public function vertaaSalasanojaJaAnnaHash($salasana1, $salasana2) {
        if ($salasana1 == $salasana2) {
            return md5($salasana1);
        } else {
            return null;
        }
    }

    public function setSahkoposti($sahkoposti) {
        $this->sahkoposti = $sahkoposti;
        if (trim($this->sahkoposti) == '') {
            $this->virheet['sahkoposti'] = "Sähköposti ei saa olla tyhjä.";
        } else if (strlen($this->sahkoposti) > 50) {
            $this->virheet['sahkoposti'] = "Sahkoposti on liian pitkä.";
        } else {
            unset($this->virheet['sahkoposti']);
        }
    }

    public function setLiittymispaiva($liittymispaiva) {
        return $this->liittymispaiva = $liittymispaiva;
    }

    public function setAsema($asema) {
        return $this->asema = $asema;
    }

    public function getId() {
        return $this->id;
    }

    public function getNimimerkki() {
        return $this->nimimerkki;
    }

    public function getSalasana() {
        return $this->salasana;
    }

    public function getSahkoposti() {
        return $this->sahkoposti;
    }

    public function getLiittymispaiva() {
        return $this->liittymispaiva;
    }

    public function getAsema() {
        return $this->asema;
    }

    public function getVirheet() {
        return $this->virheet;
    }

    public function __toString() {
        // return "PuuhaajaID: "+ getId()+" Nimimerkki: "+getTunnus()+" Salasana: "+getSalasana()+"\n";
        return "Puuhaja ID: {$this->id}, Nimimerkki: {$this->nimimerkki}, Salasana {$this->salasana}\n";
    }

    /* Tekee listauksen kaikista käyttäjistä tietokannassa */

    public static function etsiKaikkiKayttajat() {
        $sql = "SELECT puuhaajaid,nimimerkki, liittymispaiva,asema, salasana FROM henkilo ORDER BY nimimerkki";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $kayttaja = new Henkilo();
            $kayttaja->setId($tulos->puuhaajaid);
            $kayttaja->setNimimerkki($tulos->nimimerkki);
            $kayttaja->setSalasana($tulos->salasana);
            $kayttaja->setLiittymispaiva($tulos->liittymispaiva);
            $kayttaja->setAsema($tulos->asema);

            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $tulokset[] = $kayttaja;
        }
        return $tulokset;
    }

    /* Etsitään kannasta käyttäjätunnuksella ja salasanalla käyttäjäriviä */

    public static function etsiKayttajaTunnuksilla($kayttaja, $salasana) {
        /*Muutetaan salasana hash muotoon*/
        $salasana=substr(md5($salasana),0,19);
        $sql = "SELECT puuhaajaid,sahkoposti,salasana,asema,nimimerkki from henkilo where sahkoposti = ? AND salasana = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttaja, $salasana));

        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        } else {
            $kayttaja = new Henkilo();
            $kayttaja->setId($tulos->puuhaajaid);
            $kayttaja->setSahkoposti($tulos->sahkoposti);
            $kayttaja->setSalasana2($tulos->salasana);
            $kayttaja->setAsema($tulos->asema);
            $kayttaja->setNimimerkki($tulos->nimimerkki);

            return $kayttaja;
        }
    }

    /* Etsii kuka on lisännyt minkäkin puuhan tietokantaan ja palauttaa listan nimimerkeistä */

    public static function EtsiLisaajat($idlista) {
        foreach ($idlista as $kayttajaid) {
            $sql = "SELECT puuhaajaid,sahkoposti,salasana,asema,nimimerkki from henkilo where puuhaajaid = ?";
            $kysely = getTietokantayhteys()->prepare($sql);
            $kysely->execute(array($kayttajaid));

            $tulos = $kysely->fetchObject();
            if (!$tulos == null) {
                $kayttajat[] = $tulos->nimimerkki;
            }
        }
        return $kayttajat;
    }

    /* Etsii henkilon nimimerkin id:n perusteella, */

    public static function EtsiKokoHenkilo($kayttajaid) {
        $sql = "SELECT puuhaajaid,sahkoposti,salasana,asema,nimimerkki from henkilo where puuhaajaid = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttajaid));

        $tulos = $kysely->fetchObject();
        if (!$tulos == null) {
            $kayttaja = new Henkilo();
            $kayttaja->setId($tulos->puuhaajaid);
            $kayttaja->setSahkoposti($tulos->sahkoposti);
            $kayttaja->setSalasana2($tulos->salasana);
            $kayttaja->setAsema($tulos->asema);
            $kayttaja->setNimimerkki($tulos->nimimerkki);
            return $kayttaja;
        }
        return null;
    }

    /* Etsii henkilon nimimerkin id:n perusteella palauttaa vain nimimerkin */

    public static function EtsiHenkilo($kayttajaid) {
        $sql = "SELECT puuhaajaid,sahkoposti,salasana,asema,nimimerkki from henkilo where puuhaajaid = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttajaid));

        $tulos = $kysely->fetchObject();
        if (!$tulos == null) {
            return $tulos->nimimerkki;
        }
        return null;
    }

    /* Lisää Henkilon tietokantaan */

    public function lisaaKantaan() {
        $sql = "INSERT INTO henkilo (nimimerkki, sahkoposti,salasana,asema, liittymispaiva) VALUES(?,?,?,?,?) RETURNING puuhaajaid";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getNimimerkki(), $this->getSahkoposti(),
            $this->getSalasana(), $this->getAsema(), $this->getLiittymispaiva()));
        if ($ok) {
            //Haetaan RETURNING-määreen palauttama id.
            //HUOM! Tämä toimii ainoastaan PostgreSQL-kannalla!
            $this->id = $kysely->fetchColumn();
        }
        return $kysely->fetchColumn();
    }

    /* Poistaa Henkilon tietokannasta */

    public static function PoistaHenkilo($puuhaajaid) {
        $sql = "DELETE FROM henkilo WHERE puuhaajaid = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($puuhaajaid));

        return $ok;
    }

    /* Palauttaa true jos annettu salasana vastaa henkilon salasanaa */

    public function TarkistaOnkoVanhaSalasanaOikein($salasana) {
        $salasana=substr(md5($salasana),0,19);

        if ($salasana == $this->salasana) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* Vaihtaa henkilö olion salasanan */

    public function VaihdaSalasana($salasana1, $salasana2) {
        $this->setSalasana($salasana1, $salasana2);
    }

    /*vaihtaa salasanan tietokantaan*/
    public function VaihdaSalasanaTietokantaan() {
        $sql = "UPDATE Henkilo SET salasana=? WHERE puuhaajaid=?";
        $kysely = getTietokantayhteys()->prepare($sql);
        
        $ok = $kysely->execute(array($this->getSalasana(), $this->getId()));
        return $ok;
    }
    
   
}
