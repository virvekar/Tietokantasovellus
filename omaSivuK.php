<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(      
        'aktiivinen' => "ei mikaan",
        'virhe' => "Kirjaudu sisään tarkastellaksesi omaa sivua.", request
    ));
}

$omatPuuhat=Puuhat::HaePuuhatTekijalla(annaKirjautuneenId());

naytaNakyma('nakymat/omaSivu.php', array(
    'nimi' => annaKirjautuneenNimimerkki(),
    'aktiivinen' => "omaSivu",
    'omatPuuhat' => $omatPuuhat
));

    