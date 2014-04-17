<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/Suositukset.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(        
        'virhe' => "Kirjaudu sisään kirjoittaaksesi suosituksen.", request
    ));
}


if(isset($_POST['submitLisaaSuositus'])){
	$puuhaid=$_POST['puuha_id'];
	/*Hae puuhan tiedot*/
 	$puuha=Puuhat::EtsiPuuha($puuhaid);
	$suositus=new Suositukset();
        $suositus->setPuuhaId($puuhaid);
	$suositus->setPuuhaajaId(annaKirjautuneenId());
  	$suositus->setSuositusTeksti($_POST['suosittelu']);

	$virheet=$suositus->getVirheet();
	if(empty($virheet)){
		$suositus->LisaaSuositus($puuhaid);
 		$_SESSION['ilmoitus'] = "Suositus on lisätty.";
		header('Location: puuhanTiedotK.php?puuhanid='.$puuhaid.'.php');
	}else{
		naytaNakyma('nakymat/suosituksenKirjoitus.php', array(
    		'aktiivinen' => "ei mikaan",
    		'puuha'=> $puuha,
    		'suositus'=> $suositus,
		'puuha'=> $puuha,
		'virhe'=>$virheet
		));
	}


} else{
  $puuhaid = (int)$_GET['puuhanid'];
/*Hae puuhan tiedot*/
 $puuha=Puuhat::EtsiPuuha($puuhaid);
}




naytaNakyma('nakymat/suosituksenKirjoitus.php', array(
    'aktiivinen' => "ei mikaan",
    'puuha'=> $puuha,
    'suositus'=>new Suositukset()
));