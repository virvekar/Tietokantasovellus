<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/luoOlio.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(
        'virhe' => "Kirjaudu sisään muokataksesi taitoa.", request
    ));
}

/*Jos taidon id löytyy get parametrista haetaan sen tiedot kannasta*/
if (isset($_GET['taidonid'])) {
    $taitoid = (int) $_GET['taidonid'];
    $uusiTaito = Taidot::EtsiTaito($taitoid);
    
}
/*Jos taitoa ei löytynyt tai sitä ei annettu annetaan virheilmoitus*/
if (empty($uusiTaito)) {
    naytaNakyma('nakymat/taidonMuokkaus.php', array(
        'aktiivinen' => "taidot",
        'uusiTaito' => $uusiTaito,
        'virhe' => "Taitoa ei löydy."
    ));
}

/*Katsotaan onko taidonmuokkausnappia painettu*/
if (isset($_POST['submittaitoMuokkaus'])) {
    /*Luodaan uusi taitomuuttuja annetuilla tiedoilla*/
    $uusiTaito = new Taidot();
    $uusiTaito->setId($taitoid);
    $uusiTaito=TaytaTaidonTiedotSyotteella($uusiTaito);
    /*Otetaan ylös virheet*/
    $virheet = $uusiTaito->getVirheet();

    /*Jos virheitä ei ollut lisätään muokkaukset kantaan*/
    if (empty($virheet)) {
        $uusiTaito->lisaaMuokkauksetKantaan();
        $_SESSION['ilmoitus'] = "Taidon muokkaus onnistui.";

            /*Kutsutaan funktiota joka näyttää oma sivu -näkymän*/
        naytaNakymaOmalleSivulle();
    } else {
        /*Jos virheitä löytyi välitetään ne näkymälle annettujen tietojen kera*/
        $virheet = $uusiTaito->getVirheet();
        naytaNakyma("nakymat/taidonMuokkaus.php", array(
            'aktiivinen' => "taidot",
            'uusiTaito' => $uusiTaito,
            'virhe' => $virheet
        ));
    }
}
/*Jos nappia ei painettu näytetään normaalinäkymä muokattavan taidon tiedoilla*/
naytaNakyma('nakymat/taidonMuokkaus.php', array(
    'aktiivinen' => "taidot",
    'uusiTaito' => $uusiTaito
));
