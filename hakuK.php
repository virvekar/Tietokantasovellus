<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/karsiKesto.php';
require_once 'tietokanta/kirjastot/karsiHenkilo.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';

$luokat = Puuhaluokka::AnnaTiedotListaukseen();

/* Tarkistetaan onko luokkaa annettu ja miten se on annettu*/
if(!empty($_POST["luokkasailio"])){
    $valittuLuokka = $_POST['luokkasailio'];
}elseif(!empty($_POST["luokka"])){
    $luokanNimi=$_POST["luokka"];
    $valittuLuokka=Puuhaluokka::AnnaPuuhaLuokanID($luokanNimi);
}

/*Tarkista että mikään arvo ei ole tyhjä */
if (!empty($valittuLuokka) && !empty($_POST["Kesto"]) && !empty($_POST["Henkilomaara"]) && !empty($_POST["Paikka"])) {
    $kesto = $_POST["Kesto"];
    $kestot = karsiKesto($kesto);
    
    $henkilomaara = $_POST["Henkilomaara"];
    $henkilomaarat = karsiHenkilo($henkilomaara);
    $paikka = $_POST["Paikka"];

    /* Tarkistaa onko puuhaluokka valittu*/
    if ($valittuLuokka == "any") {
        /* Tarkistaa onko paikka valittu*/
        if($paikka == "any"){
            $puuhat = Puuhat::HaePuuhatEiPaikkaaEiLuokkaa($kestot[0], $kestot[1], $henkilomaarat[0], $henkilomaarat[1]);
        }else{
            $puuhat = Puuhat::HaePuuhatEiLuokkaa($kestot[0], $kestot[1], $henkilomaarat[0], $henkilomaarat[1],$paikka);
        }
                   
    } else {
        if ($paikka == "any") {
            $puuhat = Puuhat::HaePuuhatEiPaikkaa($valittuLuokka, $kestot[0], $kestot[1], $henkilomaarat[0], $henkilomaarat[1]);
        } else {
            $puuhat = Puuhat::HaePuuhat($valittuLuokka, $kestot[0], $kestot[1], $henkilomaarat[0], $henkilomaarat[1], $paikka);
        }
        
    }

/* Jos puuhat on tyhjä tulostetaan virhe*/
    if (empty($puuhat)) {
        naytaNakyma('nakymat/haku.php', array(
            'aktiivinen' => "haku",
            'luokat' => $luokat,
            'virhe' => "Yhtään puuhaa ei löytynyt"
        ));
    }
    /* Tulostus jos puuhia löytyi*/
    naytaNakyma('nakymat/haku.php', array(
        'aktiivinen' => "haku",
        'luokat' => $luokat,
        'puuhat' => $puuhat
    ));
}

/* Jos puuhaluokkaan ei ole laitettu mitään annetaan pelkkä hakusivu eikä listausta*/
if (empty($valittuLuokka)) {
    naytaNakyma('nakymat/haku.php', array(
        'aktiivinen' => "haku",
        'luokat' => $luokat
    ));
}else{
    naytaNakyma('nakymat/haku.php', array(
        'aktiivinen' => "haku",
        'luokat' => $luokat,
        'virhe'=> "Yhtään puuhaa ei löytynyt."
        ));
}
