<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/karsiKesto.php';
require_once 'tietokanta/kirjastot/karsiHenkilo.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/OmatTaidot.php';
require_once 'tietokanta/kirjastot/mallit/PuuhaTaidot.php';

/* Katsotaan onko hakunappia painettu */
if (isset($_POST['submithaku'])) {
    $parametrit = LueHakuParametrit();

    /* Tarkistaa onko puuhaluokka valittu */
    if ($parametrit[0] == "any") {
        /* Tarkistaa onko paikka valittu */
        if ($parametrit[3] == "any") {
            $puuhat = Puuhat::HaePuuhatEiPaikkaaEiLuokkaa($parametrit[1][0], $parametrit[1][1], $parametrit[2][0], $parametrit[2][1]);
        } else {
            $puuhat = Puuhat::HaePuuhatEiLuokkaa($parametrit[1][0], $parametrit[1][1], $parametrit[2][0], $parametrit[2][1], $parametrit[3]);
        }
    } else {
        if ($parametrit[3] == "any") {
            $puuhat = Puuhat::HaePuuhatEiPaikkaa($parametrit[0], $parametrit[1][0], $parametrit[1][1], $parametrit[2][0], $parametrit[2][1]);
        } else {
            $puuhat = Puuhat::HaePuuhat($parametrit[0], $parametrit[1][0], $parametrit[1][1], $parametrit[2][0], $parametrit[2][1], $parametrit[3]);
        }
    }
    /* Katsotaan onko taitojen rajaus otettu kayttoon */
    if (isset($_POST['taitorajaus'])) {
        /* Valitsee puuhat jotka sisältävät vain käyttäjän osaamia taitoja */
        $puuhat = KarsiTaitojenMukaan($puuhat, $parametrit[4]);
    }
    /* Jos puuhat on tyhjä tulostetaan virhe */

    if (empty($puuhat)) {
        NaytaHakuNakyma(null, "Yhtään puuhaa ei löytynyt");
    }
    /* Tulostus jos puuhia löytyi */
    NaytaHakuNakyma($puuhat, null);
}

/* Katsotaan onko arvonappia painettu */
if (isset($_POST['submitarvo'])) {
    ArvoPuuha();
}

/* Naytetaan normaalinakyma */
NaytaHakuNakyma(null, null);



/* ---------------------------------------------------------------------------- */

/* Lukee syötetyt hakuparametrit ja palauttaa ne listassa */

function LueHakuParametrit() {
    $parametrit = array();
    $parametrit[] = LueAnnettuLuokka();
    $parametrit[] = karsiKesto($_POST["Kesto"]);
    $parametrit[] = karsiHenkilo($_POST["Henkilomaara"]);
    $parametrit[] = $_POST["Paikka"];

    /* Jos henkilo on kirjautunut katsotaan taitorajaus */
    if (OnkoKirjautunut()) {
        $parametrit[] = Taitorajaus();
    }
    return $parametrit;
}

/* Katsoo millä tavalla luokka on annettu  ja palauttaa sen */

function LueAnnettuLuokka() {

    /* Tarkistetaan onko luokkaa annettu ja miten se on annettu */
    if (!empty($_POST["luokka"])) {
        $luokanNimi = $_POST["luokka"];
        $valittuLuokka = Puuhaluokka::AnnaPuuhaLuokanID($luokanNimi);
    } elseif (!empty($_POST["luokkasailio"])) {
        $valittuLuokka = $_POST["luokkasailio"];
    } else {
        return null;
    }
    return $valittuLuokka;
}

/* Arpoo puuhan ja nayttaa sen nakymassa */

function ArvoPuuha() {
    $maara = Puuhat::kokonaismaara();
    $luku = rand(0, $maara - 1);
    $puuhat = array();
    $puuhat[] = Puuhat::OtaSatunnaisPuuha($luku);
    NaytaHakuNakyma($puuhat, null);
}

/* Etsii kayttajan osaamat taidot */

function Taitorajaus() {
    /* Jos taitorajaus on valittu palautetaan kayttajan osaamat taidot */
    if (isset($_POST['taitorajaus'])) {
        $taidot = OmatTaidot::AnnaKayttajanTaidot(annaKirjautuneenId());
        return $taidot;
    }
    return array();
}

/* Palauttaa puuhat joiden taidoissa ei vaadita muita kuin $taidot listassa annettuja taitoja */

function KarsiTaitojenMukaan($puuhat, $taidot) {

    $hyvaksytytPuuhat = array();
    foreach ($puuhat as $puuha) {
        $puuhanTaidot = PuuhaTaidot:: AnnaPuuhanTaidot($puuha->getId());
        if (!OnkoOsaamattomiaTaitoja($puuhanTaidot, $taidot)) {
            $hyvaksytytPuuhat[] = $puuha;
        }
    }
    return $hyvaksytytPuuhat;
}

/* Palauttaa true, jos $puuhanTaidot listassa on taitoja joita ei ole $omatTaidot listassa */

function OnkoOsaamattomiaTaitoja($puuhanTaidot, $omatTaidot) {
    if (empty($puuhanTaidot)) {
        return false;
    } else {
        foreach ($puuhanTaidot as $puuhataito) {
            if (!OnkoTaitoListassa($puuhataito, $omatTaidot)) {
                return true;
            }
        }
    }
}

/* Palauttaa true, mikäli taito löytyy listasta */

function OnkoTaitoListassa($taito, $lista) {
    foreach ($lista as $arvo) {
        if ($taito == $arvo) {
            return true;
        }
    }
    return false;
}
