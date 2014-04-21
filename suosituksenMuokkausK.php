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
        'virhe' => "Kirjaudu sisään muokataksesi suositusta.", request
    ));
}

if(isset($_POST['submitLisaaSuositus'])){
  
	$puuhaid=$_POST['puuha_id'];
        $suositusid=$_POST['suositus_id'];
	/*Hae puuhan tiedot*/
 	$puuha=Puuhat::EtsiPuuha($puuhaid);
	$suositus=new Suositukset();
        $suositus->setPuuhaId($puuhaid);
        $suositus->setSuositusId($suositusid);
	$suositus->setPuuhaajaId(annaKirjautuneenId());
  	$suositus->setSuositusTeksti($_POST['suosittelu']);

	$virheet=$suositus->getVirheet();
	if(empty($virheet)){
            error_log(print_r($suositus, TRUE)); 
		$suositus->lisaaMuokkauksetKantaan();
 		$_SESSION['ilmoitus'] = "Suositus on lisätty.";
		header('Location: puuhanTiedotK.php?puuhanid='.$puuhaid.'.php');
	}else{
		naytaNakyma('nakymat/suosituksenKirjoitus.php', array(
    		'aktiivinen' => "ei mikaan",
    		'puuha'=> $puuha,
    		'suositus'=> $suositus,
		'virhe'=>$virheet,
                'tyyppi'=> "Muokkaus"
		));
	}


} else{
  $suositusid = (int)$_GET['suositusid'];
/*Hae suosituksen tiedot*/

 $suositus=Suositukset::EtsiSuositus($suositusid);
 error_log(print_r($suositus->getPuuhaId(), TRUE)); 
 $puuha=Puuhat::EtsiPuuha($suositus->getPuuhaId());
}




naytaNakyma('nakymat/suosituksenKirjoitus.php', array(
    'aktiivinen' => "ei mikaan",
    'puuha'=> $puuha,
    'suositus'=> $suositus,
    'tyyppi'=> "Muokkaus"
));