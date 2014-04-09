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
        
        $sivuNumero = 1;
        $montakoLuokkaaSivulla = 20;

//Kysytään mallilta Luokkia sivulla $sivu, 
        $luokat = Puuhaluokka::AnnaTiedotListaukseetRajattu($montakoLuokkaaSivulla, $sivuNumero);

//Luokkien kokonaislukumäärä haetaan, jotta tiedetään montako sivua kissoja kokonaisuudessa on:
        $luokkaLkm = Puuhaluokka::lukumaara();
        $sivuja = ceil($luokkaLkm / $montakoLuokkaaSivulla);

        $sarakeMontako = Puuhaluokka::AnnaSarakeMontakoPuuhaaLuokassa($luokat);
        $sarakeViimeisinLisaysPaiva = Puuhaluokka::AnnaSarakeViimeisinLisaysPaiva($luokat);
            
        //Luokka lisättiin kantaan onnistuneesti, lähetetään käyttäjä eteenpäin
        naytaNakyma('nakymat/puuhat.php', array(
            'aktiivinen' => "puuhat",
            'luokat' => $luokat,
            'sarakeMontako' => $sarakeMontako,
            'sarakePaiva' => $sarakeViimeisinLisaysPaiva,
            'sivuNumero' => $sivuNumero,
            'sivuja'=>$sivuja,
            'montakoSivulla'=>$montakoLuokkaaSivulla
        
));

        
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

