<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/kirjauduUlos.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Suosikit.php';
require_once 'tietokanta/kirjastot/mallit/OmatTaidot.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakymaKirjautumisSivulleVirheella();
}

/*Tarkistetaan onko painettu nappia puuhan poistamiseksi suosikeista*/
if (isset($_POST['submitPoistaSuosikeista'])) {
    $puuhanid=$_POST['puuha_id'];
    /*Poistetaan puuha henkilon suosikeista*/
    Suosikit::PoistaSuosikeista($puuhanid,  annaKirjautuneenId());
}

/*Tarkisteaan onko painettu nappia taidon poistamiseksi omista taidoista*/
if (isset($_POST['submitPoistaOmistaTaidoista'])) {
    $taidonid=$_POST['taito_id'];
    /*Poistetaan taito henkilon osaamista taidoista*/
    OmatTaidot::PoistaOmistaTaidoista($taidonid,  annaKirjautuneenId());
}

/*Katsotaan onko painettu nappia rekisteröitymisen poistamiseksi*/
if (isset($_POST['submitPoistaHenkilo'])) {
    /*Poisteaan kirjautunut henkilo järjestelmästä*/
    Henkilo::PoistaHenkilo(annaKirjautuneenId());
    $_SESSION['ilmoitus'] = "Olet poistanut rekisteröitymisesi järjestelmästä";
     KirjauduUlos();

}

naytaNakymaOmalleSivulle();

    