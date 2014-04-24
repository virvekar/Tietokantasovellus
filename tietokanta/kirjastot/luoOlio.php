<?php

/* Antaa puuhalle arvoksi syötetyt tiedot */

function TaytaPuuhanTiedotSyotteella($uusiPuuha) {

    /* Tarkistetaan onko luokkaa annettu ja miten se on annettu */
    if (!empty($_POST["luokkasailio"])) {
        /* Otetaan luokka dropvalikosta */
        $valittuLuokka = $_POST['luokkasailio'];
    } elseif (!empty($_POST["luokka"])) {
        /* Otetaan luokka tekstikentästä */
        $luokanNimi = $_POST["luokka"];
        $valittuLuokka = Puuhaluokka::AnnaPuuhaLuokanID($luokanNimi);
    }
    /* Tarkistetaan onko paikkaa annettu ja miten se on annettu */
    if (!empty($_POST["paikka"])) {
        /* Otetaan paikka tekstikentästä */
        $paikka = $_POST['paikka'];
    } elseif (!empty($_POST["paikkasailio"])) {
        /* Otetaan paikka dropvalikosta */
        $paikka = $_POST["paikkasailio"];
    }

    /* Otetaan aika syötteestä */

    /* Katsotaan onko sekä päivä että kellonaika kentään syötetty jotakin */
    if (!empty($_POST["paiva"]) && !empty($_POST["kellonaika"])) {
        /* Luodaan datetime objekti */
        $ajankohta = date_create_from_format("j.n.Y G.i", $_POST['paiva'] . " " . $_POST['kellonaika']);

        /* Lisätään ajankohta puuhalle */
        $uusiPuuha->setAjankohta($ajankohta);

        /* Katsotaan onko pelkkä  päivä annettu */
    } elseif (!empty($_POST["paiva"])) {
        /* Luodaan datetime objekti siten että kellon aika on 00.00 */
        $ajankohta = date_create_from_format("j.n.Y G.i", $_POST['paiva'] . " 00.00");
        /* Lisätään ajankohta puuhalle */
        $uusiPuuha->setAjankohta($ajankohta);

        /* Katsotaan onko pelkkä kellonaika annettu */
    } elseif (!empty($_POST["kellonaika"])) {
        /* Annetaan puuhalle ajankohdaksi null */
        $ajankohta = null;
        $uusiPuuha->setAjankohta($ajankohta);
    }

    /* Tarkistetaan onko taitoja annettu */
    $nollaSailio = array();
    $nollaSailio[] = 0;
    if ($_POST["taitosailio"] != $nollaSailio) {

        /* Otetaan taidot dropvalikosta */
        $taitojenIdt = $_POST['taitosailio'];
    } else {

        $taitojenIdt = array();
    }
    if (!empty($_POST["taito"])) {
        /* Otetaan taidot tekstikentästä */
        $taitojenNimet = $_POST["taito"];
        $nimiLista = explode(',', $taitojenNimet);
        $idLista = Taidot::AnnaTaitojenIDt($nimiLista);
    } else {
        $idLista = array();
    }
    $taidot = array_merge($taitojenIdt, $idLista);

    /* Asetetaan puuhalle arvot */
    $uusiPuuha->setNimi($_POST['nimi']);
    $uusiPuuha->setKuvaus($_POST['kuvaus']);
    $uusiPuuha->setHenkilomaara($_POST['henkilomaara']);
    $uusiPuuha->setKesto($_POST['kesto']);
    $uusiPuuha->setPaikka($paikka);
    $uusiPuuha->setPuuhaluokanId($valittuLuokka);
    $uusiPuuha->setPuuhanLisaysPaiva($date = date('Y-m-d'));
    $uusiPuuha->setLisaaja(annaKirjautuneenId());
    $uusiPuuha->setTaidot($taidot);

    return $uusiPuuha;
}

/* Antaa taidolle arvoksi syötetyt tiedot */

function TaytaTaidonTiedotSyotteella($uusiTaito) {
    $uusiTaito->setNimi($_POST['nimi']);
    $uusiTaito->setKuvaus($_POST['kuvaus']);
    $uusiTaito->setTaidonLisaysPaiva($date = date('Y-m-d'));
    $uusiTaito->setLisaaja(annaKirjautuneenId());
    return $uusiTaito;
}

/* Antaa henkilolle arvoksi syötetyt tiedot */

function TaytaHenkilonTiedotSyotteella($uusiHenkilo) {
    $uusiHenkilo->setNimimerkki($_POST['nimi']);
    $uusiHenkilo->setSahkoposti($_POST['sahkoposti']);
    $uusiHenkilo->setLiittymispaiva($date = date('Y-m-d'));
    $uusiHenkilo->setAsema("Puuhaaja");
    $uusiHenkilo->setSalasana($_POST['salasana'], $_POST['salasana2']);
    return $uusiHenkilo;
}

/*Luo henkilo-olion jolle annetaan sähköposti ja salasana*/

function LuoHenkiloKirjautumiseen() {
    $kayttaja = new Henkilo();
    $kayttaja->setSahkoposti($_POST["email"]);
    $kayttaja->setSalasana2($_POST["password"]);
    return $kayttaja;
}

function luoPuuhaTaidot($uusiPuuha) {

    $taitojenIdt = $uusiPuuha->getTaidot();
    foreach ($taitojenIdt as $taidonid):
        $puuhataidot = new PuuhaTaidot();
        $puuhataidot->setPuuhanId($uusiPuuha->getId());
        $puuhataidot->setTaitoId($taidonid);
        $puuhataidot->LisaaKantaan();
    endforeach;
}

function luoSuositus($puuhaid, $suositusid) {
    $suositus = new Suositukset();
    $suositus->setPuuhaId($puuhaid);
    $suositus->setSuositusId($suositusid);
    $suositus->setPuuhaajaId(annaKirjautuneenId());
    $suositus->setSuositusTeksti($_POST['suosittelu']);
    return $suositus;
}

function luoSuosikki($puuhaid) {
    $suosikki = new Suosikit();
    $suosikki->setPuuhaId($puuhaid);
    $suosikki->setPuuhaajaId(annaKirjautuneenId());
    return $suosikki;
}

function luoLuokka() {
    $uusiLuokka = new Puuhaluokka();
    $uusiLuokka->setId($puuhaluokanid);
    $uusiLuokka->setNimi($_POST['nimi']);
    $uusiLuokka->setKuvaus($_POST['kuvaus']);

    return $uusiLuokka;
}

function OlioOnVirheeton($olio) {
    $virheet = $olio->getVirheet();
    if (empty($virheet)) {
        return true;
    } else {
        return false;
    }
}
