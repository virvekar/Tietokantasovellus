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
