<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';


$sivuNumero = 1;
if (isset($_GET['sivuNumero'])) {
    $sivuNumero = (int) $_GET['sivuNumero'];

    //Sivunumero ei saa olla pienempi kuin yksi
    if ($sivuNumero < 1)
        $sivuNumero = 1;
}
$montakoLuokkaaSivulla = 20;

//Kysytään mallilta Luokkia sivulla $sivu, 
$luokat = Puuhaluokka::AnnaTiedotListaukseetRajattu($montakoLuokkaaSivulla, $sivuNumero);

//Luokkien kokonaislukumäärä haetaan, jotta tiedetään montako sivua kissoja kokonaisuudessa on:
$luokkaLkm = Puuhaluokka::lukumaara();
$sivuja = ceil($luokkaLkm / $montakoLuokkaaSivulla);


$sarakeMontako = Puuhaluokka::AnnaSarakeMontakoPuuhaaLuokassa($luokat);
$sarakeViimeisinLisaysPaiva = Puuhaluokka::AnnaSarakeViimeisinLisaysPaiva($luokat);

if (empty($luokat)) {
    naytaNakyma('nakymat/puuhat.php', array(
        'aktiivinen' => "puuhat",
        'virhe' => "Yhtään puuhaluokkaa ei ole"
    ));
}
naytaNakyma('nakymat/puuhat.php', array(
    'aktiivinen' => "puuhat",
    'luokat' => $luokat,
    'sarakeMontako' => $sarakeMontako,
    'sarakePaiva' => $sarakeViimeisinLisaysPaiva,
    'sivuNumero' => $sivuNumero,
    'sivuja'=>$sivuja,
    'montakoSivulla'=>$montakoLuokkaaSivulla
        
));

