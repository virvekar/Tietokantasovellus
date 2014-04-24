<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/luoOlio.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakymaKirjautumisSivulleVirheella();
}

/* Tarkistetaan onko kirjautunut yllapitaja */
if (!OnkoYllapitajaKirjautunut()) {
    naytaNakymaKirjautumisSivulleYllapitajaVirheella();
}

/*Jos puuhaluokan id löytyy get parametrista haetaan sen tiedot kannasta*/
if (isset($_GET['puuhaluokanid'])) {
    $puuhaluokanid = (int) $_GET['puuhaluokanid'];
    $uusiLuokka = Puuhaluokka::EtsiPuuhaluokka($puuhaluokanid);   
}

/*Jos puuhaluokkaa ei löytynyt tai sitä ei annettu annetaan virheilmoitus*/
if (empty($uusiLuokka)) {
     NaytaNakymaPuuhaluokanLisaysSivulle(new uusiLuokka(),"Muokkaus","Puuhaluokkaa ei löytynyt");
     
}

/*Tarkistetaan onko nappia painettu*/
if ( isset( $_POST['submitluokka'] ) ) { 
    LuokanMuokkausToimet();
}
/*Jos nappia ei painettu näytetään normaalinäkymä muokattavan taidon tiedoilla*/
NaytaNakymaPuuhaluokanLisaysSivulle($uusiLuokka,"Muokkaus",null);

/*----------------------------------------------------------------------------*/

/*Luo uuden puuhaluokan ja lisaa sen kantaan jos syötteessä ei ollut virheitä*/
function LuokanMuokkausToimet(){
     /*Luodaan uusi luokka muuttuja annetuilla tiedoilla*/
    $uusiLuokka = luoLuokka();   

    /*Jos virheitä ei ollut lisätään muokkaukset kantaan*/
    if (OlioOnVirheeton($uusiLuokka)) {
        $uusiLuokka->lisaaMuokkauksetKantaan();
        $_SESSION['ilmoitus'] = "Puuhaluokan muokkaus onnistui.";

            /*Kutsutaan funktiota joka näyttää puuhat -näkymän*/
        naytaNakymaPuuhatSivulle(1);
    } else {
        /*Jos virheitä löytyi välitetään ne näkymälle annettujen tietojen kera*/
        $virheet=$uusiLuokka->getVirheet();
        NaytaNakymaPuuhaluokanLisaysSivulle($uusiLuokka,"Muokkaus",$virheet);
        
    }
}