<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/PuuhaTaidot.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/luoOlio.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakymaKirjautumisSivulleVirheella();
}

/* Tarkistetaan onko käyttäjä blokattu */
if (Henkilo::OnkoBlokattu(annaKirjautuneenId())) {
    $_SESSION['ilmoitus'] = "Et voi lisätä puuhaa.";
    naytaNakymaPuuhatSivulle(1);
}

/* Katsotaan onko puuhan lisäysnappia painettu */
if (isset($_POST['submitpuuha'])) {
    PuuhanLisaysToimet();
}
/* Jos nappia ei ole painettu näytetään normaalinäkymä */
NaytaNakymaPuuhanLisaysSivulle(new Puuhat(), "Lisays", null);

/* ---------------------------------------------------------------------------- */

/*Tarkistaa puuhan syotteen ja lisaa puuhan kantaan jos syote oli hyva, lopuksi 
ohjataan kayttaja puuhat sivulle */
function PuuhanLisaysToimet() {
    /* Kutsutaan funktiota joka asettaa puuhalle arvot syötteestä */
    $uusiPuuha = TaytaPuuhanTiedotSyotteella(new Puuhat());

    /* Jos ei virheitä lisätään puuha kantaan */
    if (OlioOnVirheeton($uusiPuuha)) {

        /* Jos ajankohta on tyhjä kutsutaan funktiota joka ei aseta tietokantaan aikaa */
        if (is_null($uusiPuuha->getAjankohta())) {
            $uusiPuuha->lisaaKantaanEiAikaa();
            LisayskenJalkitoimet($uusiPuuha);
            /* Jos ajankohta ei ole tyhjä kutsutaan funktiota joka asettaa tietokantaan myös ajan */
        } else {
            $uusiPuuha->lisaaKantaan();
            LisayskenJalkitoimet($uusiPuuha);
        }
    } else {
        /* Jos virheitä oli näytetään virheilmoitus ja välitetään puuhan tiedot näkymälle */
        $virheet = $uusiPuuha->getVirheet();
        NaytaNakymaPuuhanLisaysSivulle($uusiPuuha, "Lisays", $virheet);
    }
}

/*Annetaan ilmoitus, luodaan puuhataidot ja ohjataan kayttaja puuhat sivulle*/
function LisayskenJalkitoimet($uusiPuuha) {
    $_SESSION['ilmoitus'] = "Puuha lisätty kantaan.";

    luoPuuhaTaidot($uusiPuuha);
    /* Viedään käyttäjä puuhat sivulle */
    naytaNakymaPuuhatSivulle(1);
}
