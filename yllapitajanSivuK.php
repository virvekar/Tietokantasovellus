<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(
        'aktiivinen' => "ei mikaan",
        'virhe' => "Kirjaudu sisään tarkastellaksesi yllapitajan sivua.", request
    ));
}

/* Tarkistetaan onko kirjautunut yllapitaja */
if (!OnkoYllapitajaKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(
        'aktiivinen' => "ei mikaan",
        'virhe' => "Vain ylläpitäjä voi tarkastella ylläpitäjän sivua.", request
    ));
}

/* Haetaan lista kayttajista */
$kayttajat = Henkilo::etsiKaikkiKayttajat();

/* Katsotaan onko puuhan poistonappia painettu */
if (isset($_POST['submitPoistaPuuha'])) {
    /* Katsotaan onko kenttään annettu jokin arvo */
    if (!empty($_POST["poistettavaPuuha"])) {

        $nimi = $_POST['poistettavaPuuha'];
        $puuha = Puuhat::EtsiPuuhaNimella($nimi);
        /* Jos puuha löytyy poistetaan se */
        if (!empty($puuha)) {
            Puuhat::PoistaPuuha($puuha->getId());
            $_SESSION['ilmoitus'] = "Puuha poistettu onnistuneesti.";
            naytaNakyma('nakymat/yllapitajanSivu.php', array(
                'aktiivinen' => "omaSivu",
                'henkilot' => $kayttajat
            ));
        } else {
            /* Jos puuhaa ei löytynyt näytetään virheilmoitus */
            naytaNakyma('nakymat/yllapitajanSivu.php', array(
                'aktiivinen' => "omaSivu",
                'henkilot' => $kayttajat,
                'virhe' => "Puuhaa ei loytynyt.", request
            ));
        }
    } else {
        /* Jos kenttä oli tyhjä niin annetaan virheilmoitus */
        naytaNakyma('nakymat/yllapitajanSivu.php', array(
            'aktiivinen' => "omaSivu",
            'henkilot' => $kayttajat,
            'virhe' => "Syötä poistettava puuha.", request
        ));
    }
}
/* Katsotaan onko puuhaluokan poistonappia painettu */
if (isset($_POST['submitPoistaPuuhaluokka'])) {
    /* Katsotaan onko kenttään annettu jokin arvo */
    if (!empty($_POST["poistettavaPuuhaluokka"])) {

        $nimi = $_POST['poistettavaPuuhaluokka'];
        $puuhaluokka = Puuhaluokka::AnnaPuuhaLuokanID($nimi);
        

        /* Jos puuhaluokka löytyy poistetaan se */
        if (!empty($puuhaluokka)) {
            Puuhaluokka::PoistaPuuhaluokka($puuhaluokka);
            $_SESSION['ilmoitus'] = "Puuhaluokka poistettu onnistuneesti.";
            naytaNakyma('nakymat/yllapitajanSivu.php', array(
                'aktiivinen' => "omaSivu",
                'henkilot' => $kayttajat
            ));
        } else {
            /* Jos puuhaluokkaa ei löytynyt annetaan virheilmoitus */
            naytaNakyma('nakymat/yllapitajanSivu.php', array(
                'aktiivinen' => "omaSivu",
                'henkilot' => $kayttajat,
                'virhe' => "Puuhaluokkaa ei loytynyt.", request
            ));
        }
    } else {
        /* Jos kenttä oli tyhjä annetaan virheilmoitus */
        naytaNakyma('nakymat/yllapitajanSivu.php', array(
            'aktiivinen' => "omaSivu",
            'henkilot' => $kayttajat,
            'virhe' => "Syötä poistettava puuhaluokka.", request
        ));
    }
}

/* Katsotaan onko taidon poistonappia painettu */
if (isset($_POST['submitPoistaTaito'])) {
    /* Katsotaan onko kenttään annettu jokin arvo */
    if (!empty($_POST["poistettavaTaito"])) {

        $nimi = $_POST['poistettavaTaito'];
        $taito = Taidot::AnnaTaidonID($nimi);
        /* Jos taito löytyy poistetaan se */
        if (!empty($taito)) {
            Taidot::PoistaTaito($taito);
            $_SESSION['ilmoitus'] = "Taito poistettu onnistuneesti.";
            naytaNakyma('nakymat/yllapitajanSivu.php', array(
                'aktiivinen' => "omaSivu",
                'henkilot' => $kayttajat
            ));
        } else {
            /* Jos taitoa ei löytynyt annetaan virheilmoitus */
            naytaNakyma('nakymat/yllapitajanSivu.php', array(
                'aktiivinen' => "omaSivu",
                'henkilot' => $kayttajat,
                'virhe' => "Taitoa ei loytynyt.", request
            ));
        }
    } else {
        /* Jos kenttä oli tyhjä annetaan virheilmoitus */
        naytaNakyma('nakymat/yllapitajanSivu.php', array(
            'aktiivinen' => "omaSivu",
            'henkilot' => $kayttajat,
            'virhe' => "Syötä poistettava taito.", request
        ));
    }
}

if (isset($_POST['submitPoista'])) {
    $puuhaaja = $_POST['henkilo_id'];
    Henkilo::PoistaHenkilo($puuhaaja);
    $_SESSION['ilmoitus'] = "Puuhaaja poistettu onnistuneesti.";
    
    /* Haetaan lista kayttajista */
    $kayttajat = Henkilo::etsiKaikkiKayttajat();
    naytaNakyma('nakymat/yllapitajanSivu.php', array(
        'aktiivinen' => "omaSivu",
        'henkilot' => $kayttajat
    ));
}

if (isset($_POST['submitKorota'])) {
    $puuhaajaid = $_POST['henkilo_id'];
    $puuhaaja=Henkilo::EtsiKokoHenkilo($puuhaajaid);
    $puuhaaja->VaihdaYllapitajaksi();
    $_SESSION['ilmoitus'] = "Puuhaaja on korotetty Ylläpitäjäksi.";
    
     /* Haetaan lista kayttajista */
    $kayttajat = Henkilo::etsiKaikkiKayttajat();
    naytaNakyma('nakymat/yllapitajanSivu.php', array(
        'aktiivinen' => "omaSivu",
        'henkilot' => $kayttajat
    ));
}
if (isset($_POST['submitBlokkaa'])) {
    $puuhaajaid = $_POST['henkilo_id'];
    $puuhaaja=Henkilo::EtsiKokoHenkilo($puuhaajaid);
    $puuhaaja->Blokkaa();
    $_SESSION['ilmoitus'] = "Puuhaaja on blokattu.";
    
     /* Haetaan lista kayttajista */
    $kayttajat = Henkilo::etsiKaikkiKayttajat();
    naytaNakyma('nakymat/yllapitajanSivu.php', array(
        'aktiivinen' => "omaSivu",
        'henkilot' => $kayttajat
    ));
}

if (isset($_POST['submitPoistaBlokkaus'])) {
    $puuhaajaid = $_POST['henkilo_id'];
    $puuhaaja=Henkilo::EtsiKokoHenkilo($puuhaajaid);
    $puuhaaja->PoistaBlokkaus();
    $_SESSION['ilmoitus'] = "Puuhaajan blokkaus on poistettu.";
    
     /* Haetaan lista kayttajista */
    $kayttajat = Henkilo::etsiKaikkiKayttajat();
    naytaNakyma('nakymat/yllapitajanSivu.php', array(
        'aktiivinen' => "omaSivu",
        'henkilot' => $kayttajat
    ));
}

/* Jos mitään nappia ei ole painettu näytetään sivu normaalisti */
naytaNakyma('nakymat/yllapitajanSivu.php', array(
    'aktiivinen' => "omaSivu",
    'henkilot' => $kayttajat
));

