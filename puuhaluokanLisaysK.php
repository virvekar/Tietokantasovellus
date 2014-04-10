<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(
        'virhe' => "Kirjaudu sisään lisätäksesi puuhaluokan.", request
    ));
}
    
if ( isset( $_POST['submitluokka'] ) ) { 
    
    $uusiLuokka = new Puuhaluokka();
    $uusiLuokka->setNimi($_POST['nimi']);
    $uusiLuokka->setKuvaus($_POST['kuvaus']);
    $virheet=$uusiLuokka->getVirheet();
    

    /* Tarksitetaan onko puuhaluokka syötetty oikein */
    if (empty($virheet)) {
        $uusiLuokka->lisaaKantaan();
        $_SESSION['ilmoitus'] = "Puuhaluokka lisätty onnistuneesti.";  
        
        naytaNakymaPuuhatSivulle();

        
    } else {
        $virheet = $uusiLuokka->getVirheet();

        //Virheet voidaan nyt välittää näkymälle syötettyjen tietojen kera
        naytaNakyma("nakymat/puuhaluokanLisays.php", array(
            'aktiivinen' => "puuhat",
            'uusiLuokka' => $uusiLuokka,
            'virhe' => $virheet
        ));
    }
}
naytaNakyma('nakymat/puuhaluokanLisays.php', array(
    'aktiivinen' => "puuhat",
    'uusiLuokka' => new Puuhaluokka()
));

