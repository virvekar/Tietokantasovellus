<?php
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';


$puuhaid = (int)$_GET['puuhanid'];
$puuha = Puuhat::EtsiPuuha($puuhaid);
$lisaaja=Henkilo::EtsiLisaaja($puuha->getLisaaja());
if(empty($puuha)){
    naytaNakyma('nakymat/puuhanTiedot.php', array(
    'aktiivinen' => "puuhat",
    'virhe' => "Puuhaa ei löydy."
));
}
$luokanNimi=Puuhaluokka::AnnaPuuhaLuokka($puuha->getPuuhaluokanId());

naytaNakyma('nakymat/puuhanTiedot.php', array(
    'aktiivinen' => "puuhat",
    'puuha' => $puuha,
    'luokanNimi' => $luokanNimi,
    'lisaaja'=>$lisaaja,
    'kirjautuneenid'=>  annaKirjautuneenId()
));

