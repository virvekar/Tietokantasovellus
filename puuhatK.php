<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/sivunumerointi.php';


$sivuNumero = 1;

/*Katsotaan onko sivunumero annettu*/
if (isset($_GET['sivuNumero'])) {
    $sivunumero=OtaSivunumero();
}

/*Tarkistetaan onko poista nappia painettu*/
if (isset($_POST['submitPoista'])) {
    
    $LuokkaId=$_POST['puuhaLuokka_id'];  
    Puuhaluokka::PoistaPuuhaluokka($LuokkaId);
     $_SESSION['ilmoitus'] = "Puuhaluokka poistettu onnistuneesti.";
}
/*Kutsutaan funktiota joka näytää puuhat näkymän*/
naytaNakymaPuuhatSivulle($sivuNumero);

