<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/luoOlio.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(
        'virhe' => "Kirjaudu sisään lisätäksesi taidon.", request
    ));
}

/* Katsotaan onko taidonlisäysnappia painettu */
if (isset($_POST['submittaito'])) {
    /* Luodaan taitomuuttuja ja annetaan sille tarvittavat tiedot */
    $uusiTaito = new Taidot();
    $uusiTaito=TaytaTaidonTiedotSyotteella($uusiTaito);
    /* Otetaan ylös virheet */
    $virheet = $uusiTaito->getVirheet();

    /* Jos virheitä ei ollut lisätään taito tietokantaan */
    if (empty($virheet)) {
        $uusiTaito->lisaaKantaan();
        $_SESSION['ilmoitus'] = "Taito lisätty kantaan.";

        /* Kutsutaan funktiota joka näyttää sivutetun taidot näkymän */
        naytaNakymaTaidotSivulle(1);
    } else {
        /* Jos virheitä oli välitetään ne näkymälle täytettyjen tietojen kera */
        $virheet = $uusiTaito->getVirheet();
        naytaNakyma("nakymat/taidonLisays.php", array(
            'aktiivinen' => "taidot",
            'uusiTaito' => $uusiTaito,
            'virhe' => $virheet
        ));
    }
}

/*Jos taidonlisäys nappia ei oltu painettu näyteään normaalinäkymä*/
naytaNakyma('nakymat/taidonLisays.php', array(
    'aktiivinen' => "taidot",
    'uusiTaito' => new Taidot()
));
