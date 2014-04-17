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


/* Tarkistaa onko lisää suosikkeihin nappia painettu*/
if(isset($_POST['submitLisaaSuosikkeihin'])){
    /*Otetaan puuha id post muutujana näkymän formilta*/
    $puuhaid=$_POST['puuha_id'];
    $suosikki = new Suosikit();
    $suosikki->setPuuhaId($puuhaid);
    $suosikki->setPuuhaajaId(annaKirjautuneenId());
    /*Lisätään puuha suosikkeihin*/
    $suosikki->LisaaSuosikkeihin();
    $_SESSION['ilmoitus'] = "Puuha lisätty suosikkeihin.";
}else{
    /*Otetaan puuhaid get parametrina*/
    $puuhaid = (int)$_GET['puuhanid'];
}

/* Tarkistaa onko poista nappia painettu*/
if(isset($_POST['submitPoista'])){
     $puuhaid=$_POST['puuha_id'];
     $poistettavaPuuha=Puuhat::EtsiPuuha($puuhaid);
     Puuhat::PoistaPuuha($puuhaid);
     $_SESSION['ilmoitus'] = "Puuha poistettu onnistuneesti.";
     /*Kutsutaan funktiota joka näyttää luokanPuuhat näkymän*/
    naytaNakymaLuokanPuuhatSivulle(1,$poistettavaPuuha->getPuuhaluokanId());
}

/* Haetaan puuhan ja sen lisääjän tiedot*/
$puuha = Puuhat::EtsiPuuha($puuhaid);
$lisaaja=Henkilo::EtsiHenkilo($puuha->getLisaaja());
if(empty($puuha)){
    naytaNakyma('nakymat/puuhanTiedot.php', array(
    'aktiivinen' => "puuhat",
    'virhe' => "Puuhaa ei löydy."
));
}
/*Haetaan puuhaluokan nimi*/
$luokanNimi=Puuhaluokka::AnnaPuuhaLuokka($puuha->getPuuhaluokanId());

/*Haetaan puuhaan liittyvät taidot*/
$taitojenIdt=PuuhaTaidot::AnnaPuuhanTaidot($puuhaid);
$taitojenNimet=Taidot::EtsiTaitojenNimet($taitojenIdt);

/*Haetaan puuhaan liittyvät suositukset*/
$suositukset=Suositukset::AnnaSuositukset($puuhaid);

/*Välitetään tiedot näkymälle */
naytaNakyma('nakymat/puuhanTiedot.php', array(
    'aktiivinen' => "puuhat",
    'puuha' => $puuha,
    'luokanNimi' => $luokanNimi,
    'lisaaja'=>$lisaaja,
    'kirjautuneenid'=>  annaKirjautuneenId(),
    'taitojenNimet'=> $taitojenNimet,
    'suositukset'=> $suositukset
));

