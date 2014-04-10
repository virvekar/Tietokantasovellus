<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/Suosikit.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(
        'virhe' => "Kirjaudu sisään laittaaksesi puuhan suosikkeihin.", request
    ));
}
$omatPuuhat=Puuhat::HaePuuhatTekijalla(annaKirjautuneenId());
$omatTaidot=Taidot::HaeTaidotTekijalla(annaKirjautuneenId());

if (isset($_GET['puuhanid'])) {
    $puuhaid = (int) $_GET['puuhanid'];
    $suosikki = new Suosikit();
    $suosikki->setPuuhaId($puuhaid);
    $suosikki->setPuuhaajaId(annaKirjautuneenId());
    error_log(print_r($suosikki, TRUE)); 
    $suosikki->LisaaSuosikkeihin();
    $_SESSION['ilmoitus'] = "Puuha lisätty suosikkeihin.";
    
    naytaNakyma('nakymat/omaSivu.php', array(
    'nimi' => annaKirjautuneenNimimerkki(),
    'aktiivinen' => "omaSivu",
    'omatPuuhat' => $omatPuuhat,
    'omatTaidot' => $omatTaidot
));
}else{
    naytaNakyma('nakymat/omaSivu.php', array(
    'nimi' => annaKirjautuneenNimimerkki(),
    'aktiivinen' => "omaSivu",
    'omatPuuhat' => $omatPuuhat,
    'omatTaidot' => $omatTaidot,
        'virhe' => "Puuhaa ei löytynyt.", request
            ));
}


