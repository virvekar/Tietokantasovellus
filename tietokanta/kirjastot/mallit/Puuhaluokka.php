<?php

class Puuhaluokka {

    private $id;
    private $nimi;
    private $kuvaus;

    public function __construct() {
        
    }

    /* Tähän gettereitä ja settereitä */

    public function setId($id) {
        $this->id = $id;
    }

    public function setNimi($nimi) {
        $this->nimi = $nimi;
    }

    public function setKuvaus($kuvaus) {
        $this->kuvaus = $kuvaus;
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

    public static function AnnaTiedotListaukseen() {
        $sql = "SELECT puuhaluokanid, puuhaluokanNimi, puuhaluokanKuvaus FROM puuhaluokka";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $puuhaluokka = new Puuhaluokka();
            $puuhaluokka->setId($tulos->puuhaluokanid);
            $puuhaluokka->setNimi($tulos->puuhaluokannimi);
            $puuhaluokka->setKuvaus($tulos->puuhaluokankuvaus);


            $tulokset[] = $puuhaluokka;
        }
        return $tulokset;
    }

    public function MontakoPuuhaaLuokassa($luokanid) {
        $sql = "SELECT COUNT(puuhanid) AS luokanpuuhat FROM puuhat WHERE puuhaluokanid= ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($luokanid));

        $tulos = $kysely->fetchObject();

        return $tulos->luokanpuuhat;
    }

    /* Ottaa vastaan listan Puuhaluokkia ja palauttaa listan, jossa on kunkin 
      puuhaluokan sisältämien puuhien määrä */

    public static function AnnaSarakeMontakoPuuhaaLuokassa($lista) {
        $tulokset = array();
        foreach ($lista as $puuhaluokka):
            $tulokset[] = $puuhaluokka->MontakoPuuhaaLuokassa($puuhaluokka->getId());
        endforeach;
        return $tulokset;
    }

    public static function AnnaViimeisinLisaysPaiva($luokanid) {
        $sql = "Select max(puuhanLisaysPaiva) AS viimeisinpaiva
                from puuhat
                where puuhaluokanid = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($luokanid));

        $tulos = $kysely->fetchObject();
        if (is_null($tulos->viimeisinpaiva)) {
            return "-";
        }
        return $tulos->viimeisinpaiva;
    }

    public static function AnnaSarakeViimeisinLisaysPaiva($lista) {
        $tulokset = array();
        foreach ($lista as $puuhaluokka):
            $tulokset[] = $puuhaluokka->AnnaViimeisinLisaysPaiva($puuhaluokka->getId());
        endforeach;
        return $tulokset;
    }

    public static function AnnaPuuhaLuokka($luokanid) {
        $sql = "SELECT puuhaluokanid, puuhaluokanNimi, puuhaluokanKuvaus FROM puuhaluokka WHERE puuhaluokanid= ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($luokanid));


        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        } else {
            $puuhaluokka = new Puuhaluokka();
            $puuhaluokka->setId($tulos->puuhaluokanid);
            $puuhaluokka->setNimi($tulos->puuhaluokannimi);
            $puuhaluokka->setKuvaus($tulos->puuhaluokankuvaus);
        }
        return $puuhaluokka->getNimi();
    }

}
