<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/luoOlio.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(
        'virhe' => "Kirjaudu sisään muokataksesi puuhaa.", request
    ));
}

/* Otetaan muokattava puuha getillä */
$puuhaid = (int) $_GET['puuhanid'];
/* Haetaan puuha tietokannasta */
$uusiPuuha = Puuhat::EtsiPuuha($puuhaid);
$uusiPuuha->setId($puuhaid);

/* Haetaan puuhaluokat ja taidot dropvalikkoja varten */
$luokat = Puuhaluokka::AnnaTiedotListaukseen();
$taidot = Taidot::AnnaTaitoListaus();

/* Jos puuhaa ei löydy näytetään virheilmoitus */
if (empty($uusiPuuha)) {
    naytaNakyma('nakymat/puuhanMuokkaus.php', array(
        'aktiivinen' => "puuhat",
        'uusiPuuha' => $uusiPuuha,
        'luokat' => $luokat,
        'taidot' => $taidot,
        'virhe' => "Puuhaa ei löydy."
    ));
}



/* Onko nappia painettu */
if (isset($_POST['submitpuuhaMuokkaus'])) {

        /*Kutsutaan funktiota joka asettaa puuhalle arvot syötteestä*/
    $uusiPuuha=TaytaPuuhanTiedotSyotteella($uusiPuuha);
    
    /*Otetaan ylös virheet*/
    $virheet = $uusiPuuha->getVirheet();


    /* Jos ei virheitä lisätään muokkaukset kantaan */
    if (empty($virheet)) {
        /*Jos ajankohta on tyhjä kutsutaan funktiota joka ei aseta tietokantaan aikkaa*/
        if (empty($ajankohta)) {
            $uusiPuuha->lisaaMuokkauksetKantaanEiAikaa();
            $_SESSION['ilmoitus'] = "Muutokset tallennetu.";

            /*Lähetetään käyttäjä omalle sivulle*/
            header('Location: omaSivuK.php');
            
        /*Jos ajankohta ei ole tyhjä kutsutaan funktiota joka asettaa tietokantaan myös ajan */
        } else {
            $uusiPuuha->lisaaMuokkauksetKantaan();
            $_SESSION['ilmoitus'] = "Muutokset tallennetu.";

            /*Lähetetään käyttäjä omalle sivulle*/
            header('Location: omaSivuK.php');
        }
    } else {
        /*Jos virheitä oli näytetään virheilmoitus ja välitetään puuhan tiedot näkymälle*/
        $virheet = $uusiPuuha->getVirheet();     
        naytaNakyma("nakymat/puuhanMuokkaus.php", array(
            'aktiivinen' => "puuhat",
            'uusiPuuha' => $uusiPuuha,
            'luokat' => $luokat,
            'taidot' => $taidot,
            'virhe' => $virheet
        ));
    }
}

/*Jos nappia ei ole painettu näytetään normaalinäkymä*/
naytaNakyma('nakymat/puuhanMuokkaus.php', array(
    'aktiivinen' => "puuhat",
    'uusiPuuha' => $uusiPuuha,
    'luokat' => $luokat,
    'taidot' => $taidot
));

