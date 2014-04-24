<?php

require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/mallit/Suosikit.php';
require_once 'tietokanta/kirjastot/mallit/PuuhaTaidot.php';
require_once 'tietokanta/kirjastot/mallit/Suositukset.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/luoOlio.php';


/* Tarkistaa onko lisää suosikkeihin nappia painettu */
if (isset($_POST['submitLisaaSuosikkeihin'])) {
    SuosikinLisaysToimet();
} else {
    /* Otetaan puuhaid get parametrina */
    $puuhaid = (int) $_GET['puuhanid'];
}

/* Tarkistaa onko poista nappia painettu */
if (isset($_POST['submitPoista'])) {
    puuhanPoistoToimet();
}

/* Tarkistaa onko suosituksen poisto nappia painettu */
if (isset($_POST['submitPoistaSuositus'])) {
    SuosituksenPoistoToimet();
}

/* Haetaan puuhan tiedot */
$puuha = Puuhat::EtsiPuuha($puuhaid);


/*Katsotaan löytyikö puuha*/
if (is_null($puuha->getId())) {
    NaytaNakymaPuuhanTiedotSivulle(new Puuhat(),"Puuhaa ei löydy.");
  
}


/* Välitetään tiedot näkymälle */
NaytaNakymaPuuhanTiedotSivulle($puuha,$virheet);

/* ---------------------------------------------------------------------------- */


/*Suoritetaan puuhan poisto suosikeista*/
function SuosikinLisaysToimet() {
    /* Otetaan puuha id post muutujana näkymän formilta */
    $puuhaid = $_POST['puuha_id'];
    luoSuosikki($puuhaid);
    /* Lisätään puuha suosikkeihin */
    $suosikki->LisaaSuosikkeihin();
    $_SESSION['ilmoitus'] = "Puuha lisätty suosikkeihin.";
}

/*Suoritetaaan puuhan poisto tietokannasta*/
function puuhanPoistoToimet() {
    $puuhaid = $_POST['puuha_id'];
    $poistettavaPuuha = Puuhat::EtsiPuuha($puuhaid);
    Puuhat::PoistaPuuha($puuhaid);
    $_SESSION['ilmoitus'] = "Puuha poistettu onnistuneesti.";
    /* Kutsutaan funktiota joka näyttää luokanPuuhat näkymän */
    naytaNakymaLuokanPuuhatSivulle(1, $poistettavaPuuha->getPuuhaluokanId());
}

/*Suoritetaan suosituksen poistaminen*/
function SuosituksenPoistoToimet() {
    $suositusid = $_POST['suositus_id'];
    Suositukset::PoistaSuositus($suositusid);
    $_SESSION['ilmoitus'] = "Suositus poistettu onnistuneesti.";
}
