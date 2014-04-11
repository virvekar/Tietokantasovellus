<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(        
        'virhe' => "Kirjaudu sisään kirjoittaaksesi suosituksen.", request
    ));
}

/*Tähän tulee toiminnallisuus suosituksen lisäämiseksi*/


naytaNakyma('nakymat/suosituksenKirjoitus.php', array(
    'aktiivinen' => "ei mikaan"
));