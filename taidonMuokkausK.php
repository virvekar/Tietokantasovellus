<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(        
        'virhe' => "Kirjaudu sisään muokataksesi taitoa.", request
    ));
}
naytaNakyma('nakymat/taidonMuokkaus.php', array(
    'aktiivinen' => "taidot"
));