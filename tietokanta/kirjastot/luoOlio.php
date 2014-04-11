<?php

/*Antaa puuhalle arvoksi syötetyt tiedot*/
function TaytaPuuhanTiedotSyotteella($uusiPuuha){
    
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
    
    /*Katsotaan onko sekä päivä että kellonaika kentään syötetty jotakin*/
    if (!empty($_POST["paiva"]) && !empty($_POST["kellonaika"])) {
        /*Luodaan datetime objekti*/
        $ajankohta = date_create_from_format("j.n.Y G.i", $_POST['paiva'] . " " . $_POST['kellonaika']);

        /*Lisätään ajankohta puuhalle*/
        $uusiPuuha->setAjankohta($ajankohta);
        
        /*Katsotaan onko pelkkä  päivä annettu*/
    } elseif (!empty($_POST["paiva"])) {
        /*Luodaan datetime objekti siten että kellon aika on 00.00*/
        $ajankohta = date_create_from_format("j.n.Y G.i", $_POST['paiva'] . " 00.00");
        /*Lisätään ajankohta puuhalle*/
        $uusiPuuha->setAjankohta($ajankohta);
        
        /*Katsotaan onko pelkkä kellonaika annettu*/
    } elseif (!empty($_POST["kellonaika"])) {
        /*Annetaan puuhalle ajankohdaksi null*/
        $ajankohta = null;
        $uusiPuuha->setAjankohta($ajankohta);
    }

        /*Asetetaan puuhalle arvot*/
    $uusiPuuha->setNimi($_POST['nimi']);
    $uusiPuuha->setKuvaus($_POST['kuvaus']);
    $uusiPuuha->setHenkilomaara($_POST['henkilomaara']);
    $uusiPuuha->setKesto($_POST['kesto']);
    $uusiPuuha->setPaikka($paikka);
    $uusiPuuha->setPuuhaluokanId($valittuLuokka);
    $uusiPuuha->setPuuhanLisaysPaiva($date = date('Y-m-d'));
    $uusiPuuha->setLisaaja(annaKirjautuneenId());
    
    return $uusiPuuha;
}

/*Antaa taidolle arvoksi syötetyt tiedot*/
function TaytaTaidonTiedotSyotteella($uusiTaito){
    $uusiTaito->setNimi($_POST['nimi']);
    $uusiTaito->setKuvaus($_POST['kuvaus']);
    $uusiTaito->setTaidonLisaysPaiva($date = date('Y-m-d'));
    $uusiTaito->setLisaaja(annaKirjautuneenId());
    return $uusiTaito;
}

