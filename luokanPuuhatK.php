<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/mallit/Suosikit.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';

if(isset($_POST['submitLisaaSuosikkeihin'])){
    $luokanid=$_POST['luokan_id'];
    $puuhanid=$_POST['puuha_id'];
    $suosikki = new Suosikit();
    $suosikki->setPuuhaId($puuhanid);
    $suosikki->setPuuhaajaId(annaKirjautuneenId());
    $suosikki->LisaaSuosikkeihin();
    $_SESSION['ilmoitus'] = "Puuha lisätty suosikkeihin.";
}else{
    $luokanid = (int)$_GET['luokanid'];
}

$sivuNumero = 1;
if (isset($_GET['sivuNumero'])) {
    $sivuNumero = (int) $_GET['sivuNumero'];

    //Sivunumero ei saa olla pienempi kuin yksi
    if ($sivuNumero < 1){
        $sivuNumero = 1;
    }
}
$montakoLuokkaaSivulla = 20;

$puuhat = Puuhat::EtsiPuuhatLuokassaRajattu($luokanid,$montakoLuokkaaSivulla,$sivuNumero);

$puuhaLkm = Puuhat::lukumaara($luokanid);
$sivuja = ceil($puuhaLkm / $montakoLuokkaaSivulla);

if(empty($puuhat)){
    naytaNakyma('nakymat/luokanPuuhat.php', array(
    'aktiivinen' => "puuhat",
    'virhe' => "Luokassa ei ole lainkaan puuhia."
));
}
naytaNakyma('nakymat/luokanPuuhat.php', array(
    'aktiivinen' => "puuhat",
    'puuhat'=> $puuhat,
    'sivuNumero' => $sivuNumero,
    'sivuja'=>$sivuja,
    'montakoSivulla'=>$montakoLuokkaaSivulla,
    'luokanid'=>$luokanid,
    'kirjautuneenid'=>  annaKirjautuneenId(),
    'luokanid' =>$luokanid,
    
        
));
