<?php

session_start();
include 'tietokanta/kirjastot/nakymakutsut.php';
include 'tietokanta/kirjastot/onkoKirjautunut.php';
include 'tietokanta/kirjastot/kirjauduUlos.php';

require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once "tietokanta/kirjastot/mallit/Henkilo.php";

/* Jos kayttaja on jo kirjautunut niin kirjaudutaan ulos */
if (OnkoKirjautunut()) {
    KirjauduUlos();
}

/* Jos sahkopostia ja salasanaa ei ole syotetty naytetaan normaali nakyma */
if (empty($_POST["email"]) && empty($_POST["password"])) {
    naytaPohjaNakyma('tietokanta/nakymat/Kirjautuminen.php');
}

/* Jos sahkopostiosoitetta ei ole syotetty mutta salasana on naytetaan virheviesti */
if (empty($_POST["email"])) {
    naytaNakyma('tietokanta/nakymat/Kirjautuminen.php', array(
        'virhe' => "Kirjautuminen epäonnistui! Et antanut sähköpostiosoitetta.",
    ));
}
$kayttaja = $_POST["email"];

/* Jos salasanaa ei ole syotetty mutta sahkoposti on naytetaan virheviesti */
if (empty($_POST["password"])) {
    naytaNakyma('tietokanta/nakymat/Kirjautuminen.php', array(
        'kayttaja' => $kayttaja,
        'virhe' => "Kirjautuminen epäonnistui! Et antanut salasanaa.",
    ));
}
$salasana = $_POST["password"];

/* Etsitaan kirjautumista yrittava tietokannasta */
$henkilo = Henkilo::etsiKayttajaTunnuksilla($kayttaja, $salasana);

/* Tarkistetaan onko parametrina saatu oikeat tunnukset */
if (!is_null($henkilo)) {
    $_SESSION['kirjautunut'] = $henkilo;

    /* Jos tunnus on oikea, ohjataan käyttäjä hakusivulle */
    header('Location: hakuK.php');
} else {
    /* Väärän tunnuksen syöttänyt saa eteensä kirjautumislomakkeen. */
    naytaNakyma('tietokanta/nakymat/Kirjautuminen.php', array(
        /* Välitetään näkymälle tieto siitä, kuka yritti kirjautumista */
        'kayttaja' => $kayttaja,
        'virhe' => "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä.", request
    ));
}