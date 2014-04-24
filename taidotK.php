<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/OmatTaidot.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/sivunumerointi.php';

$sivuNumero = 1;

/*Katsotaan onko sivunumero annettu*/
if (isset($_GET['sivuNumero'])) {
     $sivunumero=OtaSivunumero();
}

/*Tarkistetaan onko hallitsen nappia painettu*/
if (isset($_POST['submitHallitsen'])) {
    LisaaOsattuihinTaitohin();
}

/*Tarkistetaan onko poista nappia painettu*/
if (isset($_POST['submitPoista'])) {
    TaidonPoisto();
}
/*Kutsutaan funktiota joka nayttaa taidot nakyman*/
naytaNakymaTaidotSivulle($sivuNumero);


/*-------------------------------------------------------*/

/*Etsii taidon ja lisää sen puuhaajan osaamiiin taitoihin*/
function LisaaOsattuihinTaitohin(){
    $taitoId=$_POST['taito_id'];
    $omaTaito = new omatTaidot();
    $omaTaito->setTaitoId($taitoId);
    $omaTaito->setPuuhaajaId(annaKirjautuneenId());
    /*Lisätään taito omiin taitoihin*/
    $omaTaito->LisaaOmiinTaitoihin();
}

/*Poistaa taidon tietokannasta*/
function TaidonPoisto(){
    $taitoId=$_POST['taito_id'];    
     Taidot::PoistaTaito($taitoId);
     $_SESSION['ilmoitus'] = "Taito poistettu onnistuneesti.";
}