<?php
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';

/*Palauttaa kirjautuneen henkilon nimimerkin*/
function annaKirjautuneenNimimerkki() {
    if (isset($_SESSION['kirjautunut'])) {
        $henkilo =  unserialize($_SESSION['kirjautunut']) ;
        $nimi = $henkilo->getNimimerkki();
         return $nimi;  
    }
    return null;
}

/*Palauttaa kirjautuneen henkilon id:n*/
function annaKirjautuneenId() {
    session_start();
    if (isset($_SESSION['kirjautunut'])) {
        
        $henkilo =  unserialize($_SESSION['kirjautunut']) ;
        $id = $henkilo->getId();
         return $id;  
    }
    return null;
}

