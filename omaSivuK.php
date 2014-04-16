<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Suosikit.php';
require_once 'tietokanta/kirjastot/mallit/OmatTaidot.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(      
        'aktiivinen' => "ei mikaan",
        'virhe' => "Kirjaudu sisään tarkastellaksesi omaa sivua.", request
    ));
}

/*Tarkistetaan onko painettu nappia puuhan poistamiseksi suosikeista*/
if (isset($_POST['submitPoistaSuosikeista'])) {
    $puuhanid=$_POST['puuha_id'];
    Suosikit::PoistaSuosikeista($puuhanid,  annaKirjautuneenId());
}

if (isset($_POST['submitPoistaOmistaTaidoista'])) {
    $taidonid=$_POST['taito_id'];
    OmatTaidot::PoistaOmistaTaidoista($taidonid,  annaKirjautuneenId());
}

/*Haetaan käyttäjän suosikkipuuhien id:t tietokannasta*/
$suosikkiPuuhaIDt=Suosikit::AnnaKayttajanSuosikit(annaKirjautuneenId());

/*Haetaan käyttäjän osaamien taitojen id:t tietokannasta*/
$osattujenTaitojenIDt=OmatTaidot::AnnaKayttajanTaidot(annaKirjautuneenId());

/*Haetaan suosikkipuuhien tiedot*/
$suosikkiPuuhat = array();
foreach ($suosikkiPuuhaIDt as $id):
    $suosikkiPuuhat[]=Puuhat::EtsiPuuha($id);
endforeach;

/*Haetaan osattujen taitojen tiedot*/
$osatutTaitodt = array();
foreach ($osattujenTaitojenIDt as $id):
    $osatutTaidot[]=Taidot::EtsiTaito($id);
endforeach;

/*Haetaan käyttäjän lisäämät puuhat ja taidot*/
$omatPuuhat=Puuhat::HaePuuhatTekijalla(annaKirjautuneenId());
$omatTaidot=Taidot::HaeTaidotTekijalla(annaKirjautuneenId());

/*Välitetään tiedot näkymälle*/
naytaNakyma('nakymat/omaSivu.php', array(
    'nimi' => annaKirjautuneenNimimerkki(),
    'aktiivinen' => "omaSivu",
    'omatPuuhat' => $omatPuuhat,
    'omatTaidot' => $omatTaidot,
    'suosikkiPuuhat' => $suosikkiPuuhat,
    'osatutTaidot'=>$osatutTaidot
));

    