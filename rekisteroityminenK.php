<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/luoOlio.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';



/* Katsotaan onko rekisteroitymisnappia painettu */
if (isset($_POST['submitrekisteroidy'])) {
    
    /* Luodaan Henkilö-olio ja annetaan sille tarvittavat tiedot */
    $uusiHenkilo=new Henkilo();
    $uusiHenkilo=TaytaHenkilonTiedotSyotteella($uusiHenkilo);
    
    /* Otetaan ylös virheet */
    $virheet = $uusiHenkilo->getVirheet();

    /* Jos virheitä ei ollut lisätään taito tietokantaan */
    if (empty($virheet)) {
        $idtunnus=$uusiHenkilo->lisaaKantaan();
        $_SESSION['ilmoitus'] = "Rekisteröityminen onnistui.";
         
        /*Haetaan käyttäjä vastasaatuine id tunnuksineen tietokannasta*/
$henkilo = Henkilo::EtsiKokoHenkilo($uusiHenkilo->getId());
       /* $henkilo = Henkilo::etsiKayttajaTunnuksilla($uusiHenkilo->getNimimerkki(), $uusiHenkilo->getSalasana());*/
      
        /*Kirjataan henkilo sisään*/
         $_SESSION['kirjautunut'] =serialize($henkilo); 
          error_log(print_r("Ollaanko kirjauduttu", TRUE));
        error_log(print_r(isset($_SESSION['kirjautunut']), TRUE));
        /* Kutsutaan funktiota joka näyttää oman sivun*/
        header('Location: omaSivuK.php');
    } else {
        /* Jos virheitä oli välitetään ne näkymälle täytettyjen tietojen kera */
        $virheet = $uusiHenkilo->getVirheet();
        naytaNakyma("nakymat/rekisteroityminen.php", array(
            'aktiivinen' => "ei mikaan",
            'uusiHenkilo' => $uusiHenkilo,
            'virhe' => $virheet
        ));
    }
    
}

/*Jos nappia ei ole painettu näytetään normaalinäkymä*/
naytaNakyma('nakymat/rekisteroityminen.php', array(
    'aktiivinen' => "ei mikaan",
    'uusiHenkilo' => new Henkilo()
));
