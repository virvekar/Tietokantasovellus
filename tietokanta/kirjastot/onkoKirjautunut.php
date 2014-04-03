<?php
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';

function OnkoKirjautunut() {
    session_start();
    if (isset($_SESSION['kirjautunut'])) {
        return true;
    }
    return false;
}

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
