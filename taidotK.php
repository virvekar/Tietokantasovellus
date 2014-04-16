<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/OmatTaidot.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';

$sivuNumero = 1;

/*Katsotaan onko sivunumero annettu*/
if (isset($_GET['sivuNumero'])) {
    $sivuNumero = (int) $_GET['sivuNumero'];

    //Sivunumero ei saa olla pienempi kuin yksi
    if ($sivuNumero < 1){
        $sivuNumero = 1;
    }
}

/*Tarkistetaan onko hallitsen nappia painettu*/
if (isset($_POST['submitHallitsen'])) {
    $taitoId=$_POST['taito_id'];
    $omaTaito = new omatTaidot();
    $omaTaito->setTaitoId($taitoId);
    $omaTaito->setPuuhaajaId(annaKirjautuneenId());
    /*Lisätään taito omiin taitoihin*/
    $omaTaito->LisaaOmiinTaitoihin();
}

/*Kutsutaan funktiota joka nayttaa taidot nakyman*/
naytaNakymaTaidotSivulle($sivuNumero);

