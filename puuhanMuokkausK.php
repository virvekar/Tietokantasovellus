<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/mallit/PuuhaTaidot.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/luoOlio.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
   naytaNakymaKirjautumisSivulleVirheella();
}
/* Tarkistetaan onko käyttäjä blokattu */
if (Henkilo::OnkoBlokattu(annaKirjautuneenId())) {
    $_SESSION['ilmoitus'] = "Et voi muokata puuhaa.";
    naytaNakymaPuuhatSivulle(1);
}
/*Haetaan muokattavan puuhan tiedot*/
$uusiPuuha=AlustaUusiPuuha();

/* Jos puuhaa ei löydy näytetään virheilmoitus */
if (empty($uusiPuuha)) {
    NaytaNakymaPuuhanLisaysSivulle($uusiPuuha, "Muokkaus", "Puuhaa ei löydy.");
}

/* Onko nappia painettu */
if (isset($_POST['submitpuuha'])) {
    $taitojenIdt = PuuhaTaidot::AnnaPuuhanTaidot($uusiPuuha->getId());
    PuuhanMuokkausToimet($taitojenIdt,$uusiPuuha);
}

/* Jos nappia ei ole painettu näytetään normaalinäkymä */
NaytaNakymaPuuhanLisaysSivulle($uusiPuuha, "Muokkaus", null);


/* ---------------------------------------------------------------------------- */

function PuuhanMuokkausToimet($taitojenIdt,$uusiPuuha) {
    /* Kutsutaan funktiota joka asettaa puuhalle arvot syötteestä */
    $uusiPuuha = TaytaPuuhanTiedotSyotteella($uusiPuuha);

    /* Jos ei virheitä lisätään muokkaukset kantaan */
    if (OlioOnVirheeton($uusiPuuha)) {
        /* Jos ajankohta on tyhjä kutsutaan funktiota joka ei aseta tietokantaan aikkaa */
        if (is_null($uusiPuuha->getAjankohta())) {
            $uusiPuuha->lisaaMuokkauksetKantaanEiAikaa();
            MuokkauksenJalkitoimet($uusiPuuha, $taitojenIdt);

            /* Jos ajankohta ei ole tyhjä kutsutaan funktiota joka asettaa tietokantaan myös ajan */
        } else {
            $uusiPuuha->lisaaMuokkauksetKantaan();
            MuokkauksenJalkitoimet($uusiPuuha, $taitojenIdt);
        }
    } else {
        /* Jos virheitä oli näytetään virheilmoitus ja välitetään puuhan tiedot näkymälle */
        $virheet = $uusiPuuha->getVirheet();
        NaytaNakymaPuuhanLisaysSivulle($uusiPuuha, "Muokkaus", $virheet);
    }
}

/* Poistetaan puuhaan liittyneet aiemmat taidot ja luodaan uddet yhteydet */

function UudetPuuhaTaidot($uusiPuuha, $taitojenIdt) {
    /* Poista vanhat puuhataidot */
    PuuhaTaidot::PoistaPuuhaTaidot($uusiPuuha->getId(), $taitojenIdt);
    /* luo uudet puuhataidot */
    luoPuuhaTaidot($uusiPuuha);
}

/* Asetetaan ilmoitus, paivitetaan puuhataido ja ohjataan kayttaja omalle sivulle */

function MuokkauksenJalkitoimet($uusiPuuha, $taitojenIdt) {
    $_SESSION['ilmoitus'] = "Muutokset tallennetu.";

    /* Paivitetaan puuhataidot */
    UudetPuuhaTaidot($uusiPuuha, $taitojenIdt);
    /* Lähetetään käyttäjä omalle sivulle */
    header('Location: omaSivuK.php');
}

/*Haetaan muokattavan puuhan tiedot*/
function AlustaUusiPuuha() {
    /* Otetaan muokattava puuha getillä */
    $puuhaid = (int) $_GET['puuhanid'];
    /* Haetaan puuha tietokannasta */
    $uusiPuuha = Puuhat::EtsiPuuha($puuhaid);
    $uusiPuuha->setId($puuhaid);
    /* Haetaan puuhaan liittyvät taidot */
    $taitojenIdt = PuuhaTaidot::AnnaPuuhanTaidot($puuhaid);
    $uusiPuuha->setTaidot($taitojenIdt);
    return $uusiPuuha;
}
