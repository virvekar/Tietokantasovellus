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
        'virhe' => "Kirjaudu sisään lisätäksesi puuhan.", request
    ));
}

/* Haetaan puuhaluokat ja taidot dropvalikkoja varten */
$luokat = Puuhaluokka::AnnaTiedotListaukseen();
$taidot = Taidot::AnnaTaitoListaus();

/*Katsotaan onko puuhan lisäysnappia painettu*/
if (isset($_POST['submitpuuha'])) {
    
  /*Kutsutaan funktiota joka asettaa puuhalle arvot syötteestä*/
    $uusiPuuha=TaytaPuuhanTiedotSyotteella(new Puuhat());
    $virheet = $uusiPuuha->getVirheet();


     /* Jos ei virheitä lisätään puuha kantaan */
    if (empty($virheet)) {
            /*Jos ajankohta on tyhjä kutsutaan funktiota joka ei aseta tietokantaan aikkaa*/
        if (empty($ajankohta)) {
             $uusiPuuha->lisaaKantaanEiAikaa();
           $_SESSION['ilmoitus'] = "Puuha lisätty kantaan.";

            /*Viedään käyttäjä puuhat sivulle*/
            naytaNakymaPuuhatSivulle(1);
            
            /*Jos ajankohta ei ole tyhjä kutsutaan funktiota joka asettaa tietokantaan myös ajan */
        } else {
            $uusiPuuha->lisaaKantaan();
            $_SESSION['ilmoitus'] = "Puuha lisätty kantaan.";

            /*Viedään käyttäjä puuhat sivulle*/
            naytaNakymaPuuhatSivulle(1);
        
        }
    } else {
        /*Jos virheitä oli näytetään virheilmoitus ja välitetään puuhan tiedot näkymälle*/
        $virheet = $uusiPuuha->getVirheet();
        naytaNakyma("nakymat/puuhanLisays.php", array(
            'aktiivinen' => "puuhat",
            'uusiPuuha' => $uusiPuuha,
            'luokat' => $luokat,
            'taidot' => $taidot,
            'virhe' => $virheet
        ));
    }
}
/*Jos nappia ei ole painettu näytetään normaalinäkymä*/
naytaNakyma('nakymat/puuhanLisays.php', array(
    'aktiivinen' => "puuhat",
    'uusiPuuha' => new Puuhat(),
    'luokat' => $luokat,
    'taidot' => $taidot
));


