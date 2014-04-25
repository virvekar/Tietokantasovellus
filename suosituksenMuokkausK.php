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

if (isset($_POST['submitLisaaSuositus'])) {

    SuoritaMuokkausToimet();
} else {
    /* Otetaan suositusid osoiterivilta */
    $suositusid = (int) $_GET['suositusid'];

    /* Hae suosituksen tiedot */
    $suositus = Suositukset::EtsiSuositus($suositusid);
    /*Tarkistetaan löytyikö suositus*/
     if(is_null($suositus)){
         $_SESSION['ilmoitus'] = "Suositusta ei löytynyt";
         naytaNakymaPuuhatSivulle(1);
    }
    $puuha = Puuhat::EtsiPuuha($suositus->getPuuhaId());
   
    /* Katsotaan onko henkilo yllapitaja tai suosituksen lisaaja */
    if (!OnkoKirjautunutTamaHenkilo($suositus->getPuuhaajaId())) {
        $_SESSION['ilmoitus'] = "Voit muokata vain itse lisäämiäsi suosituksia.";
        NaytaNakymaPuuhanTiedotSivulle($puuha);
    }
}

naytaNakymaSuosituksenKirjoitusSivulle($puuha, $suositus, null, "Muokkaus");

/* ---------------------------------------------------------------------------- */

/* Suorittaa suosituksen lisaykseen vaadittavat toimet */

function SuoritaMuokkausToimet() {
    /* Otetaaan puuhaid ja suositus id piilotetuista kentista */
    $puuhaid = $_POST['puuha_id'];
    $suositusid = $_POST['suositus_id'];

    $suositus = luoSuositus($puuhaid, $suositusid);

    /* Hae puuhan tiedot */
    $puuha = Puuhat::EtsiPuuha($puuhaid);

    /* Tarkistetaan oliko suosituksessa virheita */
    if (OlioOnVirheeton($suositus)) {
        LisaaMuokkauksetSuositukselle($suositus);
        header('Location: puuhanTiedotK.php?puuhanid=' . $puuhaid . '.php');
    } else {
        $virheet = $suositus->getVirheet();
        naytaNakymaSuosituksenKirjoitusSivulle($puuha, $suositus, $virheet, "Muokkaus");
    }
}

/* Lisaa suosituksen tietokantaan */

function LisaaMuokkauksetSuositukselle($suositus) {
    $suositus->lisaaMuokkauksetKantaan();
    $_SESSION['ilmoitus'] = "Suositus on lisätty.";
}
