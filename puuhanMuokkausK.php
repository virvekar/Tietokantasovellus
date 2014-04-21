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
    naytaNakyma('nakymat/Kirjautuminen.php', array(
        'virhe' => "Kirjaudu sisään muokataksesi puuhaa.", request
    ));
}
/*Tarkistetaan onko käyttäjä blokattu*/
if (Henkilo::OnkoBlokattu(annaKirjautuneenId())) {
    $_SESSION['ilmoitus'] = "Et voi muokata puuhaa.";
    naytaNakymaPuuhatSivulle(1);
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
    naytaNakyma('nakymat/puuhanLisays.php', array(
        'aktiivinen' => "puuhat",
        'uusiPuuha' => $uusiPuuha,
        'luokat' => $luokat,
        'taidot' => $taidot,
        'virhe' => "Puuhaa ei löydy.",
        'tyyppi' => "Muokkaus"
    ));
}

/*Haetaan puuhaan liittyvät taidot*/
$taitojenIdt=PuuhaTaidot::AnnaPuuhanTaidot($puuhaid);
$uusiPuuha->setTaidot($taitojenIdt);

/* Onko nappia painettu */
if (isset($_POST['submitpuuha'])) {

        /*Kutsutaan funktiota joka asettaa puuhalle arvot syötteestä*/
    $uusiPuuha=TaytaPuuhanTiedotSyotteella($uusiPuuha);
    
    /*Otetaan ylös virheet*/
    $virheet = $uusiPuuha->getVirheet();


    /* Jos ei virheitä lisätään muokkaukset kantaan */
    if (empty($virheet)) {
        /*Jos ajankohta on tyhjä kutsutaan funktiota joka ei aseta tietokantaan aikkaa*/
        if (is_null($uusiPuuha->getAjankohta())) {
            $uusiPuuha->lisaaMuokkauksetKantaanEiAikaa();
            $_SESSION['ilmoitus'] = "Muutokset tallennetu.";

	    /*Poista vanhat puuhataidot*/
	    PuuhaTaidot::PoistaPuuhaTaidot($uusiPuuha->getId(),$taitojenIdt);
	    /*luo uudet puuhataidot*/
 	    luoPuuhaTaidot($uusiPuuha);
            /*Lähetetään käyttäjä omalle sivulle*/
            header('Location: omaSivuK.php');
            
        /*Jos ajankohta ei ole tyhjä kutsutaan funktiota joka asettaa tietokantaan myös ajan */
        } else {
            $uusiPuuha->lisaaMuokkauksetKantaan();
            $_SESSION['ilmoitus'] = "Muutokset tallennetu.";

 /*Poista vanhat puuhataidot*/
	    PuuhaTaidot::PoistaPuuhaTaidot($uusiPuuha->getId(),$taitojenIdt);
	    /*luo uudet puuhataidot*/
	     luoPuuhaTaidot($uusiPuuha);
            /*Lähetetään käyttäjä omalle sivulle*/
            header('Location: omaSivuK.php');
        }
    } else {
        /*Jos virheitä oli näytetään virheilmoitus ja välitetään puuhan tiedot näkymälle*/
        $virheet = $uusiPuuha->getVirheet();     
        naytaNakyma("nakymat/puuhanLisays.php", array(
            'aktiivinen' => "puuhat",
            'uusiPuuha' => $uusiPuuha,
            'luokat' => $luokat,
            'taidot' => $taidot,
            'virhe' => $virheet,
             'tyyppi' => "Muokkaus"
        ));
    }
}

/*Jos nappia ei ole painettu näytetään normaalinäkymä*/
naytaNakyma('nakymat/puuhanLisays.php', array(
    'aktiivinen' => "puuhat",
    'uusiPuuha' => $uusiPuuha,
    'luokat' => $luokat,
    'taidot' => $taidot,
    'tyyppi' => "Muokkaus"
));

