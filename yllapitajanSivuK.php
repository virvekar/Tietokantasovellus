<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakymaKirjautumisSivulleVirheella();
}

/* Tarkistetaan onko kirjautunut yllapitaja */
else if (!OnkoYllapitajaKirjautunut()) {
    naytaNakymaKirjautumisSivulleYllapitajaVirheella();
}

/* Katsotaan onko puuhan poistonappia painettu */
else if (isset($_POST['submitPoistaPuuha'])) {
    PuuhanPoisto();
}
/* Katsotaan onko puuhaluokan poistonappia painettu */
else if (isset($_POST['submitPoistaPuuhaluokka'])) {
    PuuhaluokanPoisto();
}

/* Katsotaan onko taidon poistonappia painettu */
else if (isset($_POST['submitPoistaTaito'])) {
    TaidonPoisto();
}

/* Katsotaan onko henkilön poistonappia painettu */
else if (isset($_POST['submitPoista'])) {
    HenkilonPoisto();
}

/* Katsotaan onko korota ylläpitäjäksi nappia painettu */
else if (isset($_POST['submitKorota'])) {
    YllapitajaksiKorottaminen();
}

/* Katsotaan onko blokkaus nappia painettu */
else if (isset($_POST['submitBlokkaa'])) {
    Blokkaus();
}

/* Katsotaan onko blokkauksen poisto nappia painettu */
else if (isset($_POST['submitPoistaBlokkaus'])) {
    BlokkauksenPoisto();
}

/* Jos mitään nappia ei ole painettu näytetään sivu normaalisti */
naytaNakymaYllapitajanSivulle();

/* -------------------------------------------------------------------------------- */
/* Funktiot jotka huolehtivat poistoista: */


/* Huolehtii puuhan poistamisesta */

function PuuhanPoisto() {
    /* Katsotaan onko kenttään annettu jokin arvo */
    if (!empty($_POST["poistettavaPuuha"])) {

        $nimi = $_POST['poistettavaPuuha'];
        $puuha = Puuhat::EtsiPuuhaNimella($nimi);
        /* Jos puuha löytyy poistetaan se */
        if (!empty($puuha)) {
            Puuhat::PoistaPuuha($puuha->getId());
            $_SESSION['ilmoitus'] = "Puuha poistettu onnistuneesti.";
            /* Kutsutaan functiota joka nayttaa nakyman yllapitajan sivulle */
            naytaNakymaYllapitajanSivulle(null);
        } else {
            /* Jos puuhaa ei löytynyt näytetään virheilmoitus */
            naytaNakymaYllapitajanSivulle("Puuhaa ei loytynyt.");
        }
    } else {
        /* Jos kenttä oli tyhjä niin annetaan virheilmoitus */
        naytaNakymaYllapitajanSivulle("Syötä poistettava puuha.");
    }
}

/* Huolehtii puuhaluokan poistamisesta */

function PuuhaluokanPoisto() {
    /* Katsotaan onko kenttään annettu jokin arvo */
    if (!empty($_POST["poistettavaPuuhaluokka"])) {

        $nimi = $_POST['poistettavaPuuhaluokka'];
        $puuhaluokka = Puuhaluokka::AnnaPuuhaLuokanID($nimi);


        /* Jos puuhaluokka löytyy poistetaan se */
        if (!empty($puuhaluokka)) {
            Puuhaluokka::PoistaPuuhaluokka($puuhaluokka);
            $_SESSION['ilmoitus'] = "Puuhaluokka poistettu onnistuneesti.";
            /* Kutsutaan functiota joka nayttaa nakyman yllapitajan sivulle */
            naytaNakymaYllapitajanSivulle(null);
        } else {
            /* Jos puuhaluokkaa ei löytynyt annetaan virheilmoitus */
            naytaNakymaYllapitajanSivulle("Puuhaluokkaa ei loytynyt.");
        }
    } else {
        /* Jos kenttä oli tyhjä annetaan virheilmoitus */
        naytaNakymaYllapitajanSivulle("Syötä poistettava puuhaluokka.");
    }
}

/* Huolehtii taidon poistamisesta */

function TaidonPoisto() {
    /* Katsotaan onko kenttään annettu jokin arvo */
    if (!empty($_POST["poistettavaTaito"])) {

        $nimi = $_POST['poistettavaTaito'];
        $taito = Taidot::AnnaTaidonID($nimi);
        /* Jos taito löytyy poistetaan se */
        if (!empty($taito)) {
            Taidot::PoistaTaito($taito);
            $_SESSION['ilmoitus'] = "Taito poistettu onnistuneesti.";
            /* Kutsutaan functiota joka nayttaa nakyman yllapitajan sivulle */
            naytaNakymaYllapitajanSivulle(null);
        } else {
            /* Jos taitoa ei löytynyt annetaan virheilmoitus */
            naytaNakymaYllapitajanSivulle("Taitoa ei loytynyt.");
        }
    } else {
        /* Jos kenttä oli tyhjä annetaan virheilmoitus */
        naytaNakymaYllapitajanSivulle("Syötä poistettava taito.");
    }
}

/* Huolehtii Henkilon poistamisesta */

function HenkilonPoisto() {
    /* otetaan id piiloteutusta kentästä */
    $puuhaaja = $_POST['henkilo_id'];
    /* Poistetaan henkilo */
    Henkilo::PoistaHenkilo($puuhaaja);
    $_SESSION['ilmoitus'] = "Puuhaaja poistettu onnistuneesti.";

    /* Kutsutaan functiota joka nayttaa nakyman yllapitajan sivulle */
    naytaNakymaYllapitajanSivulle(null);
}

/* Huolehtii ylläpitäjäksi korottamisesta */

function YllapitajaksiKorottaminen() {
    /* otetaan id piiloteutusta kentästä */
    $puuhaajaid = $_POST['henkilo_id'];
    /* Korotetaan henkilo yllapitajaksi */
    $puuhaaja = Henkilo::EtsiKokoHenkilo($puuhaajaid);
    $puuhaaja->VaihdaYllapitajaksi();
    $_SESSION['ilmoitus'] = "Puuhaaja on korotetty Ylläpitäjäksi.";

    /* Kutsutaan functiota joka nayttaa nakyman yllapitajan sivulle */
    naytaNakymaYllapitajanSivulle(null);
}

/* Huolehtii puuhaaajan blokkaamisesta. Blokattu käyttäjä ei voi lisätä tai
 *  muokata mitään sivun sisältöä */

function Blokkaus() {
    /* otetaan id piiloteutusta kentästä */
    $puuhaajaid = $_POST['henkilo_id'];
    $puuhaaja = Henkilo::EtsiKokoHenkilo($puuhaajaid);
    /* Blokataan puuhaaja */
    $puuhaaja->Blokkaa();
    $_SESSION['ilmoitus'] = "Puuhaaja on blokattu.";

    /* Kutsutaan functiota joka nayttaa nakyman yllapitajan sivulle */
    naytaNakymaYllapitajanSivulle(null);
}

/* Huolehtii puuhaajan blokkauksen poistamisesta */

function BlokkauksenPoisto() {
    /* otetaan id piiloteutusta kentästä */
    $puuhaajaid = $_POST['henkilo_id'];
    $puuhaaja = Henkilo::EtsiKokoHenkilo($puuhaajaid);
    /* Poistetaan blokkaus */
    $puuhaaja->PoistaBlokkaus();
    $_SESSION['ilmoitus'] = "Puuhaajan blokkaus on poistettu.";

    /* Kutsutaan functiota joka nayttaa nakyman yllapitajan sivulle */
    naytaNakymaYllapitajanSivulle(null);
}
