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
    naytaNakymaKirjautumisSivulleVirheella();
}
/* Tarkistetaan onko käyttäjä blokattu */
if (Henkilo::OnkoBlokattu(annaKirjautuneenId())) {
    $_SESSION['ilmoitus'] = "Et voi lisätä taitoa.";
    naytaNakymaTaidotSivulle(1);
}

/* Katsotaan onko taidonlisäysnappia painettu */
if (isset($_POST['submittaito'])) {
    /* Kutsutaan funktiota joka luo taito-olion ja lisää sen tietokantaan mikali
      syöte kelpaa */
    TaidonLisaysToimet();
}

/* Jos taidonlisäys nappia ei oltu painettu näyteään normaalinäkymä */

naytaNakymaTaidonLisaysSivulle(new Taidot(), "Lisays", null);
/* ---------------------------------------------------------------------------- */

/* Luo taito-olion ja lisää sen kantaan mikäli syöte kelpaa. */

function TaidonLisaysToimet() {
    /* Luodaan taitomuuttuja ja annetaan sille tarvittavat tiedot */
    $uusiTaito = new Taidot();
    $uusiTaito = TaytaTaidonTiedotSyotteella($uusiTaito);

    if(OlioOnVirheeton($uusiTaito)){
        /* Taidon lisäys tietokantaan ja nakyman vaihto */
        TaidonLisays($uusiTaito);
        /* Kutsutaan funktiota joka näyttää sivutetun taidot näkymän */
        naytaNakymaTaidotSivulle(1);
    } else {
        /* Jos virheitä oli välitetään ne näkymälle täytettyjen tietojen kera */
        $virheet = $uusiTaito->getVirheet();
        naytaNakymaTaidoLisaysSivulle($uusiTaito, "Lisays", $virheet);
    }
}

function TaidonLisays($uusiTaito) {
    $uusiTaito->lisaaKantaan();
    $_SESSION['ilmoitus'] = "Taito lisätty kantaan.";
}
