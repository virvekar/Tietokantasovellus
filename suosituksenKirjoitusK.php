<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/Suositukset.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/luoOlio.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
   naytaNakymaKirjautumisSivulleVirheella();
}

/*Tarkistetaan onko suosituksen lisaysnappia painettu*/
if (isset($_POST['submitLisaaSuositus'])) {
    
  SuoritaLisaysToimet();

} else {
    
    /*Otetaan puuhaid osoiterivilta*/
    $puuhaid = (int) $_GET['puuhanid'];
    /* Hae puuhan tiedot */
    $puuha = Puuhat::EtsiPuuha($puuhaid);
}


/*Naytetaan normaalinakyma*/
naytaNakymaSuosituksenKirjoitusSivulle($puuha, new Suositukset(), null, "Lisays");

/* ---------------------------------------------------------------------------- */


/*Suorittaa suosituksen lisaykseen vaadittavat toimet*/
function SuoritaLisaysToimet(){
      /*Otetaan puuhaId piilotetustaKentasta*/
    $puuhaid = $_POST['puuha_id'];
    
    /* Hae puuhan tiedot */
    $puuha = Puuhat::EtsiPuuha($puuhaid);
    $suositus=luoSuositus($puuhaid,null);
    
    /*Tarkistetaan oliko suosituksessa virheita*/
    if(OlioOnVirheeton($suositus)){
        LisaaSuositus($suositus,$puuhaid);
        header('Location: puuhanTiedotK.php?puuhanid=' . $puuhaid . '.php');
    } else {
        $virheet = $suositus->getVirheet();
        naytaNakymaSuosituksenKirjoitusSivulle($puuha, $suositus, $virheet, "Lisays");
    }
}
/*Lisaa suosituksen tietokantaan*/
function LisaaSuositus($suositus,$puuhaid) {
    $suositus->LisaaSuositus($puuhaid);
    $_SESSION['ilmoitus'] = "Suositus on lisätty.";
    
}
