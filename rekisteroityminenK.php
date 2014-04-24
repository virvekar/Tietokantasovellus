<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/luoOlio.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';



/* Katsotaan onko rekisteroitymisnappia painettu */
if (isset($_POST['submitrekisteroidy'])) {

    /* Luodaan Henkilö-olio ja annetaan sille tarvittavat tiedot */
    $uusiHenkilo = new Henkilo();
    $uusiHenkilo = TaytaHenkilonTiedotSyotteella($uusiHenkilo);

    /* Jos virheitä ei ollut lisätään henkilo tietokantaan */
    if (OlioOnVirheeton($uusiHenkilo)) {
        $idtunnus = $uusiHenkilo->lisaaKantaan();

        KirjaaHenkiloSisaan($uusiHenkilo);
        $_SESSION['ilmoitus'] = "Rekisteröityminen onnistui.";
        /* Kutsutaan funktiota joka näyttää oman sivun */
        header('Location: omaSivuK.php');
    } else {
        /* Jos virheitä oli välitetään ne näkymälle täytettyjen tietojen kera */
        $virheet = $uusiHenkilo->getVirheet();
        NaytaNakymaRekisteroitymisSivulle($uusiHenkilo, $virheet);
    }
}

/* Jos nappia ei ole painettu näytetään normaalinäkymä */
NaytaNakymaRekisteroitymisSivulle(new Henkilo(), null);


/* ---------------------------------------------------------------------------- */

/* Hakee henkilon tiedot ja kirjaa taman sisaan */

function KirjaaHenkiloSisaan($uusiHenkilo) {
    session_start();
    /* Haetaan käyttäjä vastasaatuine id tunnuksineen tietokannasta */
    $henkilo = Henkilo::EtsiKokoHenkilo($uusiHenkilo->getId());

    /* Kirjataan henkilo sisään */
    $_SESSION['kirjautunut'] = serialize($henkilo);
}
