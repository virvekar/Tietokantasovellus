<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(
        'virhe' => "Kirjaudu sisään muokataksesi taitoa.", request
    ));
}

if (isset($_GET['taidonid'])) {
    $taitoid = (int) $_GET['taidonid'];
    $uusiTaito = Taidot::EtsiTaito($taitoid);
    
}

if (empty($uusiTaito)) {
    naytaNakyma('nakymat/taidonMuokkaus.php', array(
        'aktiivinen' => "taidot",
        'uusiTaito' => $uusiTaito,
        'virhe' => "Taitoa ei löydy."
    ));
}
if (isset($_POST['submittaitoMuokkaus'])) {
    $uusiTaito = new Taidot();
    error_log(print_r($taitoid, TRUE)); 
    $uusiTaito->setId($taitoid);
    $uusiTaito->setNimi($_POST['nimi']);
    $uusiTaito->setKuvaus($_POST['kuvaus']);
    $uusiTaito->setTaidonLisaysPaiva($date = date('Y-m-d'));
    $uusiTaito->setLisaaja(annaKirjautuneenId());
    $virheet = $uusiTaito->getVirheet();

    if (empty($virheet)) {
        $uusiTaito->lisaaMuokkauksetKantaan();
        $_SESSION['ilmoitus'] = "Taidon muokkaus onnistui.";

        $omatPuuhat = Puuhat::HaePuuhatTekijalla(annaKirjautuneenId());
        $omatTaidot = Taidot::HaeTaidotTekijalla(annaKirjautuneenId());

        naytaNakyma('nakymat/omaSivu.php', array(
            'nimi' => annaKirjautuneenNimimerkki(),
            'aktiivinen' => "omaSivu",
            'omatPuuhat' => $omatPuuhat,
            'omatTaidot' => $omatTaidot
        ));
    } else {
        $virheet = $uusiTaito->getVirheet();
error_log(print_r("virheita loytyi", TRUE)); 
        //Virheet voidaan nyt välittää näkymälle syötettyjen tietojen kera
        naytaNakyma("nakymat/taidonMuokkaus.php", array(
            'aktiivinen' => "taidot",
            'uusiTaito' => $uusiTaito,
            'virhe' => $virheet
        ));
    }
}

naytaNakyma('nakymat/taidonMuokkaus.php', array(
    'aktiivinen' => "taidot",
    'uusiTaito' => $uusiTaito
));
