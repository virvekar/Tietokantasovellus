<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/mallit/Suosikit.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';

/* Tarkistetaan onko lisää suosikkeihin nappia painettu */
if (isset($_POST['submitLisaaSuosikkeihin'])) {
    /* Otetaan luokan ja puuhan id:t post parametreina näkymän formilta */
    $luokanid = $_POST['luokan_id'];
    $puuhanid = $_POST['puuha_id'];
    $suosikki = new Suosikit();
    $suosikki->setPuuhaId($puuhanid);
    $suosikki->setPuuhaajaId(annaKirjautuneenId());
    /*Lisätään puuha suosikkeihin*/
    $suosikki->LisaaSuosikkeihin();
    $_SESSION['ilmoitus'] = "Puuha lisätty suosikkeihin.";
} else {
    /* Otetaan luokan ide get parametrina osoitteesta */
    $luokanid = (int) $_GET['luokanid'];
}

/* Tarkistaa onko poista nappia painettu*/
if(isset($_POST['submitPoista'])){
     $puuhaid=$_POST['puuha_id'];
     $luokanid = $_POST['luokan_id'];
     Puuhat::PoistaPuuha($puuhaid);
     $_SESSION['ilmoitus'] = "Puuha poistettu onnistuneesti.";
   
} else {
    /* Otetaan luokan ide get parametrina osoitteesta */
    $luokanid = (int) $_GET['luokanid'];
}

/* Katsotaan onko sivunumero annettu */
$sivuNumero = 1;
if (isset($_GET['sivuNumero'])) {
    $sivuNumero = (int) $_GET['sivuNumero'];

    //Sivunumero ei saa olla pienempi kuin yksi
    if ($sivuNumero < 1) {
        $sivuNumero = 1;
    }
}
/*Kutsutaan funktiota joka näyttää luokanPuuhat näkymän*/
naytaNakymaLuokanPuuhatSivulle($sivuNumero,$luokanid);