<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Suosikit.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(      
        'aktiivinen' => "ei mikaan",
        'virhe' => "Kirjaudu sisään tarkastellaksesi omaa sivua.", request
    ));
}

if (isset($_POST['submitPoistaSuosikeista'])) {
    $puuhanid=$_POST['puuha_id'];
    Suosikit::PoistaSuosikeista($puuhanid,  annaKirjautuneenId());
}

$suosikkiPuuhaIDt=Suosikit::AnnaKayttajanSuosikit(annaKirjautuneenId());

$suosikkiPuuhat = array();
foreach ($suosikkiPuuhaIDt as $id):
    $suosikkiPuuhat[]=Puuhat::EtsiPuuha($id);
endforeach;
$omatPuuhat=Puuhat::HaePuuhatTekijalla(annaKirjautuneenId());
$omatTaidot=Taidot::HaeTaidotTekijalla(annaKirjautuneenId());

naytaNakyma('nakymat/omaSivu.php', array(
    'nimi' => annaKirjautuneenNimimerkki(),
    'aktiivinen' => "omaSivu",
    'omatPuuhat' => $omatPuuhat,
    'omatTaidot' => $omatTaidot,
    'suosikkiPuuhat' => $suosikkiPuuhat
));

    