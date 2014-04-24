<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/karsiKesto.php';
require_once 'tietokanta/kirjastot/karsiHenkilo.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';

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

    /* Jos puuhat on tyhjä tulostetaan virhe */
    
    if (empty($puuhat)) {
        NaytaHakuNakyma(null,"Yhtään puuhaa ei löytynyt");
        
    }
    /* Tulostus jos puuhia löytyi */
    NaytaHakuNakyma($puuhat,null);
    
}
NaytaHakuNakyma(null,null);



/*----------------------------------------------------------------------------*/


function LueHakuParametrit() {
    $parametrit = array();
    $parametrit[] = LueAnnettuLuokka();
    $parametrit[] = karsiKesto($_POST["Kesto"]);
    $parametrit[] = karsiHenkilo($_POST["Henkilomaara"]);
    $parametrit[] = $_POST["Paikka"];

    return $parametrit;
}

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
