<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/mallit/Suosikit.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/sivunumerointi.php';

/* Tarkistetaan onko lisää suosikkeihin nappia painettu */
if (isset($_POST['submitLisaaSuosikkeihin'])) {
    /* Otetaan luokan id:t post parametreina näkymän formilta */
    $luokanid = $_POST['luokan_id'];
    
    /*Luodaan uusi suosikkiolio ja lisataan se tietokantaan*/
    SuosikinLisaysToimetListauksessa();
} 

/* Tarkistaa onko poista nappia painettu*/
if(isset($_POST['submitPoista'])){
   $luokanid = $_POST['luokan_id'];   
   PuuhanPoistoToimetListauksessa();   
} 

/*Jos kumpaakaan nappia ei painettu otetaan luokan ide get parametrina osoitteesta */
if (is_null($luokanid)){
    $luokanid = (int) $_GET['luokanid'];
}

$sivuNumero = 1;
/* Katsotaan onko sivunumero annettu */
if (isset($_GET['sivuNumero'])) {
    $sivunumero=OtaSivunumero();
}
/*Kutsutaan funktiota joka näyttää luokanPuuhat näkymän*/
naytaNakymaLuokanPuuhatSivulle($sivuNumero,$luokanid);

/*----------------------------------------------------------------------------*/

/*Luodaan uusi suosikkiolio ja lisataan se tietokantaan*/
function SuosikinLisaysToimetListauksessa(){
    
    /* Otetaan puuhan id:t post parametreina näkymän formilta */
    
    $puuhanid = $_POST['puuha_id'];
    $suosikki = new Suosikit();
    $suosikki->setPuuhaId($puuhanid);
    $suosikki->setPuuhaajaId(annaKirjautuneenId());
    /*Lisätään puuha suosikkeihin*/
    $suosikki->LisaaSuosikkeihin();
    $_SESSION['ilmoitus'] = "Puuha lisätty suosikkeihin.";
}

/*Poistetaan puuha tietokannasta*/
function PuuhanPoistoToimetListauksessa(){
      $puuhaid=$_POST['puuha_id'];
     
     Puuhat::PoistaPuuha($puuhaid);
     $_SESSION['ilmoitus'] = "Puuha poistettu onnistuneesti.";
}