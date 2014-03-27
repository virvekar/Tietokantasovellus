<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakyma('tietokanta/nakymat/Kirjautuminen.php', array(        
        'virhe' => "Kirjaudu sisään tarkastellaksesi yllapitajan sivua.", request
    ));
}

/* Tarkistetaan onko kirjautunut yllapitaja*/
if (!OnkoYllapitajaKirjautunut()) {
    naytaNakyma('tietokanta/nakymat/Kirjautuminen.php', array(        
        'virhe' => "Vain ylläpitäjä voi tarkastella ylläpitäjän sivua.", request
    ));
}
naytaNakyma('tietokanta/nakymat/yllapitajanSivu.php', array(
    'aktiivinen' => "omaSivu"
));

