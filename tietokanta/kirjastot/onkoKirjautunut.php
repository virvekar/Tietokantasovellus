<?php
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';

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
