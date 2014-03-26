<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakyma('tietokanta/nakymat/Kirjautuminen.php', array(        
        'virhe' => "Kirjaudu sisään lisätäksesi puuhan.", request
    ));
}
naytaNakyma('tietokanta/nakymat/puuhanLisays.php', array(
    'aktiivinen' => "puuhat"
));

