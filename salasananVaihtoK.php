<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/luoOlio.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakymaKirjautumisSivulleVirheella();
}

/* Katsotaan onko vaihtonappia painettu */
if (isset($_POST['submitvaihda'])) {
    SalasananVaihtoToimet();
}

/*Naytetaan normaalinakyma*/
NaytaNakymaSalasananVaihtoSivulle(null);

/*----------------------------------------------------------------------------*/

/*Suorittaa toimet salasanan vaihtamiseksi*/
function SalasananVaihtoToimet(){
    /*Haetaan henkilon id*/
     $puuhaajaid = annaKirjautuneenId();
     
    /* Haetaan henkilon tiedot */
    $henkilo = Henkilo::EtsiKokoHenkilo($puuhaajaid);
    $vanhaSalasana = $_POST['vanhaSalasana'];

    /* Funktio tarkistaa vastaako annettu salasana henkilon salasanaa */
    if ($henkilo->TarkistaOnkoVanhaSalasanaOikein($vanhaSalasana)) {

        /* Koetetaan vaihtaa henkilon salsana */
        $henkilo->VaihdaSalasana($_POST['salasana'], $_POST['salasana2']);
        
        /* Jos ei virheitä vaihdetaan salasana myös tietokantaan */
       if(OlioOnVirheeton($henkilo)){
            $henkilo->vaihdaSalasanaTietokantaan();
            $_SESSION['ilmoitus'] = "Salasana vaihdettu onnistuneesti.";

           NaytaNakymaSalasananVaihtoSivulle(null);
        } else {
            /* Virheitä löytyi, näytetään virheilmoitus */
            $virheet=$henkilo->getVirheet();
            NaytaNakymaSalasananVaihtoSivulle($virheet);

        }
    } else {
        /* Jos annettu salasana ei vastannut henkilon salasanaa, näytetään virheilmoitus */
        NaytaNakymaSalasananVaihtoSivulle("Antamasi vanha salasana on väärä.");
        
    }
}