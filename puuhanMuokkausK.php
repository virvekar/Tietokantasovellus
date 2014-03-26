<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakyma('tietokanta/nakymat/Kirjautuminen.php', array(        
        'virhe' => "Kirjaudu sisään muokataksesi puuhaa.", request
    ));
}
naytaNakyma('tietokanta/nakymat/puuhanMuokkaus.php', array(
    'aktiivinen' => "omaSivu"
));
