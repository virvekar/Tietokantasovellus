<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';


$sivuNumero = 1;

/*Katsotaan onko sivunumero annettu*/
if (isset($_GET['sivuNumero'])) {
    $sivuNumero = (int) $_GET['sivuNumero'];

    //Sivunumero ei saa olla pienempi kuin yksi
    if ($sivuNumero < 1){
        $sivuNumero = 1;
    }
}

/*Kutsutaan funktiota joka nayttaa taidot nakyman*/
naytaNakymaTaidotSivulle($sivuNumero);

