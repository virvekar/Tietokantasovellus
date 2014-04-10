<?php
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';

function annaKirjautuneenNimimerkki() {
    if (isset($_SESSION['kirjautunut'])) {
        $henkilo =  unserialize($_SESSION['kirjautunut']) ;
        $nimi = $henkilo->getNimimerkki();
         return $nimi;  
    }
    return null;
}

function annaKirjautuneenId() {
    session_start();
    if (isset($_SESSION['kirjautunut'])) {
        
        $henkilo =  unserialize($_SESSION['kirjautunut']) ;
        $id = $henkilo->getId();
         return $id;  
    }
    return null;
}

