<?php

session_start();
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/kirjauduUlos.php';

require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once "tietokanta/kirjastot/mallit/Henkilo.php";

/* Jos kayttaja on jo kirjautunut niin kirjaudutaan ulos */
if (OnkoKirjautunut()) {
    KirjauduUlos();
}

/* Jos sahkopostia ja salasanaa ei ole syotetty naytetaan normaali nakyma */
if (empty($_POST["email"]) && empty($_POST["password"])) {
    naytaNakyma('tietokanta/nakymat/Kirjautuminen.php', array(
    'aktiivinen' => "ei mikaan"
));
}

/* Jos sahkopostiosoitetta ei ole syotetty mutta salasana on naytetaan virheviesti */
if (empty($_POST["email"])) {
    naytaNakyma('tietokanta/nakymat/Kirjautuminen.php', array(
        'aktiivinen' => "ei mikaan",
        'virhe' => "Kirjautuminen epäonnistui! Et antanut sähköpostiosoitetta.",
    ));
}
$kayttaja = $_POST["email"];

/* Jos salasanaa ei ole syotetty mutta sahkoposti on naytetaan virheviesti */
if (empty($_POST["password"])) {
    naytaNakyma('tietokanta/nakymat/Kirjautuminen.php', array(
        'kayttaja' => $kayttaja,
        'aktiivinen' => "ei mikaan",
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
        'aktiivinen' => "ei mikaan",
        'virhe' => "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä.", request
    ));
}