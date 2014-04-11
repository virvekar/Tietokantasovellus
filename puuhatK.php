<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';


$sivuNumero = 1;

/*Katsotaan onko sivunumero annettu*/
if (isset($_GET['sivuNumero'])) {
    $sivuNumero = (int) $_GET['sivuNumero'];

    //Sivunumero ei saa olla pienempi kuin yksi
    if ($sivuNumero < 1)
        $sivuNumero = 1;
}
/*Kutsutaan funktiota joka näytää puuhat näkymän*/
naytaNakymaPuuhatSivulle($sivuNumero);

