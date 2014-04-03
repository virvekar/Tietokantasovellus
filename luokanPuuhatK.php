<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';

$luokanid = (int)$_GET['luokanid'];
$puuhat = Puuhat::EtsiPuuhatLuokassa($luokanid);

if(empty($puuhat)){
    naytaNakyma('nakymat/luokanPuuhat.php', array(
    'aktiivinen' => "puuhat",
    'virhe' => "Luokassa ei ole lainkaan puuhia."
));
}
naytaNakyma('nakymat/luokanPuuhat.php', array(
    'aktiivinen' => "puuhat",
    'puuhat'=> $puuhat
));
