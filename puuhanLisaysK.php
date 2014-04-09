<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(
        'virhe' => "Kirjaudu sisään lisätäksesi puuhan.", request
    ));
}

$luokat = Puuhaluokka::AnnaTiedotListaukseen();
$taidot = Taidot::AnnaTaitoListaus();

if (isset($_POST['submitpuuha'])) {
    $uusiPuuha = new Puuhat();
    /* Tarkistetaan onko luokkaa annettu ja miten se on annettu */
    if (!empty($_POST["luokkasailio"])) {
        $valittuLuokka = $_POST['luokkasailio'];
    } elseif (!empty($_POST["luokka"])) {
        $luokanNimi = $_POST["luokka"];
        $valittuLuokka = Puuhaluokka::AnnaPuuhaLuokanID($luokanNimi);
    }
    /* Tarkistetaan onko paikkaa annettu ja miten se on annettu */
    if (!empty($_POST["paikka"])) {
        $paikka = $_POST['paikka'];
    } elseif (!empty($_POST["paikkasailio"])) {
        $paikka = $_POST["paikkasailio"];
    }


    /* Ottaa ajan */
    if (!empty($_POST["paiva"]) && !empty($_POST["kellonaika"])) {
        $ajankohta = date_create_from_format("j.n.Y G.i", $_POST['paiva'] . " " . $_POST['kellonaika']);

        $uusiPuuha->setAjankohta($ajankohta);
    } elseif (!empty($_POST["paiva"])) {
        $ajankohta = date_create_from_format("j.n.Y G.i", $_POST['paiva'] . " 00.00");
        $uusiPuuha->setAjankohta($ajankohta);
    } elseif (!empty($_POST["kellonaika"])) {
        $ajankohta = null;
        $uusiPuuha->setAjankohta($ajankohta);
    }

    $uusiPuuha->setNimi($_POST['nimi']);
    $uusiPuuha->setKuvaus($_POST['kuvaus']);
    $uusiPuuha->setHenkilomaara($_POST['henkilomaara']);
    $uusiPuuha->setKesto($_POST['kesto']);
    $uusiPuuha->setPaikka($paikka);
    $uusiPuuha->setPuuhaluokanId($valittuLuokka);
    $uusiPuuha->setPuuhanLisaysPaiva($date = date('Y-m-d'));
    $uusiPuuha->setLisaaja(annaKirjautuneenId());
    $virheet = $uusiPuuha->getVirheet();


    /* Tarksitetaan onko puuha syötetty oikein */
    if (empty($virheet)) {
        $uusiPuuha->lisaaKantaanEiAikaa();
        $_SESSION['ilmoitus'] = "Puuha lisätty kantaan.";
            
        $sivuNumero = 1;
        $montakoLuokkaaSivulla = 20;

//Kysytään mallilta Luokkia sivulla $sivu, 
        $luokat = Puuhaluokka::AnnaTiedotListaukseetRajattu($montakoLuokkaaSivulla, $sivuNumero);

//Luokkien kokonaislukumäärä haetaan, jotta tiedetään montako sivua kissoja kokonaisuudessa on:
        $luokkaLkm = Puuhaluokka::lukumaara();
        $sivuja = ceil($luokkaLkm / $montakoLuokkaaSivulla);

        $sarakeMontako = Puuhaluokka::AnnaSarakeMontakoPuuhaaLuokassa($luokat);
        $sarakeViimeisinLisaysPaiva = Puuhaluokka::AnnaSarakeViimeisinLisaysPaiva($luokat);
        if (empty($ajankohta)) {

           

            //Luokka lisättiin kantaan onnistuneesti, lähetetään käyttäjä eteenpäin
            //Käytetään naytaNakyma kutsua, koska headeria kaytettäessä ilmoitus ei näy.
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
            $uusiPuuha->lisaaKantaan();
            $_SESSION['ilmoitus'] = "Puuha lisätty kantaan.";

            //Luokka lisättiin kantaan onnistuneesti, lähetetään käyttäjä eteenpäin
            //Käytetään naytaNakyma kutsua, koska headeria kaytettäessä ilmoitus ei näy.
            naytaNakyma('nakymat/puuhat.php', array(
            'aktiivinen' => "puuhat",
            'luokat' => $luokat,
            'sarakeMontako' => $sarakeMontako,
            'sarakePaiva' => $sarakeViimeisinLisaysPaiva,
            'sivuNumero' => $sivuNumero,
            'sivuja'=>$sivuja,
            'montakoSivulla'=>$montakoLuokkaaSivulla
        
));
        }
    } else {
        $virheet = $uusiPuuha->getVirheet();

        //Virheet voidaan nyt välittää näkymälle syötettyjen tietojen kera
        naytaNakyma("nakymat/puuhanLisays.php", array(
            'aktiivinen' => "puuhat",
            'uusiPuuha' => $uusiPuuha,
            'luokat' => $luokat,
            'taidot' => $taidot,
            'virhe' => $virheet
        ));
    }
}
naytaNakyma('nakymat/puuhanLisays.php', array(
    'aktiivinen' => "puuhat",
    'uusiPuuha' => new Puuhat(),
    'luokat' => $luokat,
    'taidot' => $taidot
));


