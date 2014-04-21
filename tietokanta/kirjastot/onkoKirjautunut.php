<?php
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';

/*Palauttaa true jos käyttäjä on kirjautunut sisään*/
function OnkoKirjautunut() {
    session_start();
    if (isset($_SESSION['kirjautunut'])) {
        return true;
    }
    return false;
}

/*Palauttaa true jos kirjautunut käyttäjä on ylläpitäjä*/
function OnkoYllapitajaKirjautunut() {
    if (isset($_SESSION['kirjautunut'])) {
        $henkilo =  unserialize($_SESSION['kirjautunut']) ;
        $status = $henkilo->getAsema();
        if ($status == "Yllapitaja") {
            return true;
        }      
    }
    return false;
}

/*Palauttaa true jos kirjautunut käyttäjä on ylläpitäjä tai annettu henkilo*/
function OnkoKirjautunutYllapitajaTaiTamaHenkilo($puuhaajaid) {
    if (isset($_SESSION['kirjautunut'])) {
        if (OnkoYllapitajaKirjautunut()) {
            return true;
        }else if(OnkoKirjautunutTamaHenkilo($puuhaajaid)) {
            return true;
        }    
    }
    return false;
}

/*Palauttaa true jos kirjautunut käyttäjä on annettu henkilo*/
function OnkoKirjautunutTamaHenkilo($puuhaajaid) {
    if (isset($_SESSION['kirjautunut'])) {
  $henkilo =  unserialize($_SESSION['kirjautunut']) ;
        if($henkilo->getId()==$puuhaajaid) {
            return true;
        }    
    }
    return false;
}
