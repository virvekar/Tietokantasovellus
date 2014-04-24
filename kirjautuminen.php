<?php

session_start();
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/kirjauduUlos.php';

require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/luoOlio.php';
require_once "tietokanta/kirjastot/mallit/Henkilo.php";

/* Jos kayttaja on jo kirjautunut niin kirjaudutaan ulos */
if (OnkoKirjautunut()) {
    KirjauduUlos();
}

/* Katsotaan onko kirjautumisnappia painettu */
if (isset($_POST['submitkirjautuminen'])) {

   $kayttaja=LuoHenkiloKirjautumiseen();
   
    /*Jos sahkoposti ja salasana on annettu eikä sähköposti ole liian pitkä 
     * suoritetaan kirjautumistoimet*/
    if (OlioOnVirheeton($kayttaja)) {
        KirjautumisToimet($kayttaja);
        
        /*Muutoin näytetään virheilmoitus*/
    }else{
        $virheet=$kayttaja->getVirheet();
        naytaNakymaKirjautumisSivulle($virheet, $kayttaja);
    }

   
}

/* naytetaan normaali nakyma */
naytaNakymaKirjautumisSivulle(null,new Henkilo());


/*----------------------------------------------------------------------------*/

function KirjautumisToimet($kayttaja){
     /* Etsitaan kirjautumista yrittava tietokannasta */
        $henkilo = Henkilo::etsiKayttajaTunnuksilla($kayttaja->getSahkoposti(),$kayttaja->getSalasana());

        /* Tarkistetaan onko parametrina saatu oikeat tunnukset */
        if (!is_null($henkilo)) {
            /*Kirjataan henkilo sisaan*/
            $_SESSION['kirjautunut'] = serialize($henkilo);

            /* Jos tunnus on oikea, ohjataan käyttäjä hakusivulle */
            header('Location: hakuK.php');
        } else {
            /* Väärän tunnuksen syöttänyt saa eteensä kirjautumislomakkeen. */
            naytaNakymaKirjautumisSivulle("Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä.", $kayttaja);
        }
}

