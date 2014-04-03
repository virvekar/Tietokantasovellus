<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';




$taidot = Taidot::AnnaTaitoListaus();
$lisaajaIDLista= Taidot::AnnaTaidonLisaajaListaus();
$lisaajaLista=Henkilo::EtsiLisaajat($lisaajaIDLista);
naytaNakyma('nakymat/taidot.php', array(
    'aktiivinen' => "taidot",
    'taidot' => $taidot,
    'lisaajaLista' => $lisaajaLista
        
));

