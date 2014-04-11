<?php
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/mallit/Suosikit.php';
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

/* Haetaan puuhan ja sen lisääjän tiedot*/
$puuha = Puuhat::EtsiPuuha($puuhaid);
$lisaaja=Henkilo::EtsiLisaaja($puuha->getLisaaja());
if(empty($puuha)){
    naytaNakyma('nakymat/puuhanTiedot.php', array(
    'aktiivinen' => "puuhat",
    'virhe' => "Puuhaa ei löydy."
));
}
/*Haetaan puuhaluokan nimi*/
$luokanNimi=Puuhaluokka::AnnaPuuhaLuokka($puuha->getPuuhaluokanId());

/*Välitetään tiedot näkymälle */
naytaNakyma('nakymat/puuhanTiedot.php', array(
    'aktiivinen' => "puuhat",
    'puuha' => $puuha,
    'luokanNimi' => $luokanNimi,
    'lisaaja'=>$lisaaja,
    'kirjautuneenid'=>  annaKirjautuneenId()
));

