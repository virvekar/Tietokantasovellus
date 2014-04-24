<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/luoOlio.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakymaKirjautumisSivulleVirheella();
}

/* Tarkistetaan onko käyttäjä blokattu */
if (Henkilo::OnkoBlokattu(annaKirjautuneenId())) {
    $_SESSION['ilmoitus'] = "Et voi lisätä puuhaluokkaa.";
    naytaNakymaPuuhatSivulle(1);
}

/* Katsotaan onko puuhaluokan lisays nappia painettu */
if (isset($_POST['submitluokka'])) {
    PuuhaluokanLisaysToimet();
}
NaytaNakymaPuuhaluokanLisaysSivulle(new Puuhaluokka(), "Lisays", null);

/* ---------------------------------------------------------------------------- */

/*Luodaan uusi puuhaluokka ja tallennetaan se tietokantaan mikäli syötteessä ei 
 * ollut virhetä. Lopuksi naytetaan nakuma puuhat sivulle*/
function PuuhaluokanLisaysToimet() {
    $uusiLuokka = luoLuokka();

    /* Tarksitetaan onko puuhaluokka syötetty oikein */
    if (OlioOnVirheeton($uusiLuokka)) {
        $uusiLuokka->lisaaKantaan();
        $_SESSION['ilmoitus'] = "Puuhaluokka lisätty onnistuneesti.";

        naytaNakymaPuuhatSivulle(1);
    } else {
        $virheet = $uusiLuokka->getVirheet();

        //Virheet voidaan nyt välittää näkymälle syötettyjen tietojen kera
        NaytaNakymaPuuhaluokanLisaysSivulle($uusiLuokka, "Lisays", $virheet);
    }
}
