<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';


$sivuNumero = 1;
if (isset($_GET['sivuNumero'])) {
    $sivuNumero = (int) $_GET['sivuNumero'];

    //Sivunumero ei saa olla pienempi kuin yksi
    if ($sivuNumero < 1){
        $sivuNumero = 1;
    }
}
$montakoTaitoaSivulla = 20;
$taidot = Taidot::AnnaTaitoListausRajattu($montakoTaitoaSivulla,$sivuNumero);
$lisaajaIDLista= Taidot::AnnaTaidonLisaajaListausRajattu($montakoTaitoaSivulla,$sivuNumero);
$lisaajaLista=Henkilo::EtsiLisaajat($lisaajaIDLista);

$taitoLkm = Taidot::lukumaara();
$sivuja = ceil($taitoLkm / $montakoTaitoaSivulla);

error_log(print_r($sivuja, TRUE));


if(empty($taidot)){
    naytaNakyma('nakymat/taidot.php', array(
    'aktiivinen' => "taidot",
    'virhe' => "Yhtään taitoa ei ole."
));
}
naytaNakyma('nakymat/taidot.php', array(
    'aktiivinen' => "taidot",
    'taidot' => $taidot,
    'lisaajaLista' => $lisaajaLista,
    'sivuNumero' => $sivuNumero,
    'sivuja'=>$sivuja,
    'montakoSivulla'=>$montakoTaitoaSivulla
        
));

