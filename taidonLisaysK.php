<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakyma('tietokanta/nakymat/Kirjautuminen.php', array(        
        'virhe' => "Kirjaudu sisään lisätäksesi taidon.", request
    ));
}
naytaNakyma('tietokanta/nakymat/taidonLisays.php', array(
    'aktiivinen' => "taidot"
));
