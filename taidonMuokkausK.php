<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/luoOlio.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakymaKirjautumisSivulleVirheella();
}

/* Tarkistetaan onko käyttäjä blokattu */
if (Henkilo::OnkoBlokattu(annaKirjautuneenId())) {
    $_SESSION['ilmoitus'] = "Et voi muokata taitoa.";
    naytaNakymaTaidotSivulle(1);
}

/* Hateaan taidon tiedot */
$uusiTaito = HaeTaito();



/* Jos taitoa ei löytynyt tai sitä ei annettu annetaan virheilmoitus */
if (is_null($uusiTaito)) {
    naytaNakymaTaidonMuokkausSivulleVirheella(new Taidot(), "Taitoa ei löydy.");
}
/*Katsotaan onko henkilo yllapitaja tai taidon lisaaja*/
if(!OnkoKirjautunutTamaHenkilo($uusiTaito->getLisaaja()) ){
     $_SESSION['ilmoitus'] = "Voit muokata vain itse lisäämiäsi taitoja.";
    naytaNakymaTaidotSivulle(1);
}

/* Katsotaan onko taidonmuokkausnappia painettu */
if (isset($_POST['submittaito'])) {
    TaidonMuokkausToimet($uusiTaito->getId());
}
/* Jos nappia ei painettu näytetään normaalinäkymä muokattavan taidon tiedoilla */
naytaNakymaTaidonLisaysSivulle($uusiTaito, "Muokkaus", null);


/* ---------------------------------------------------------------------------- */

/* Ottaa vastaan taidon id:n ja palauttaa taidot olion */

function HaeTaito() {
    if (isset($_GET['taidonid'])) {
        $taitoid = (int) $_GET['taidonid'];
        $uusiTaito = Taidot::EtsiTaito($taitoid);
        return $uusiTaito;
    } else {
        return null;
    }
}

/* Ottaa vastaan syötteen ja lisää muokkaukset tietokantaan */

function TaidonMuokkausToimet($taitoid) {
    /* Luodaan uusi taitomuuttuja annetuilla tiedoilla */
    $uusiTaito = new Taidot();
    $uusiTaito = TaytaTaidonTiedotSyotteella($uusiTaito);
    $uusiTaito->setId($taitoid);

   if(OlioOnVirheeton($uusiTaito)){
        MuokkauksenLisays($uusiTaito);
        /* Kutsutaan funktiota joka näyttää oma sivu -näkymän */
        naytaNakymaOmalleSivulle();
    } else {
        /* Jos virheitä löytyi välitetään ne näkymälle annettujen tietojen kera */
        $virheet = $uusiTaito->getVirheet();
        naytaNakymaTaidoLisaysSivulle($uusiTaito, "Muokkaus", $virheet);
    }
}

/* Lisaa muokkaukset kantaan */

function MuokkauksenLisays($uusiTaito) {
    $uusiTaito->lisaaMuokkauksetKantaan();
    $_SESSION['ilmoitus'] = "Taidon muokkaus onnistui.";
}
