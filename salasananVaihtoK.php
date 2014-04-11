<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(        
        'virhe' => "Kirjaudu sisään vaitaaksesi salasanaa.", request
    ));
}

/*Tähän tulee toiminnallisuus salasanan vaihtamiseksi*/

naytaNakyma('nakymat/salasananVaihto.php', array(
    'aktiivinen' => "omaSivu"
));