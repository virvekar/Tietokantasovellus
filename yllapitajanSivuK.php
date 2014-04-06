<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(   
        'aktiivinen' => "ei mikaan",
        'virhe' => "Kirjaudu sisään tarkastellaksesi yllapitajan sivua.", request
    ));
}

/* Tarkistetaan onko kirjautunut yllapitaja*/
if (!OnkoYllapitajaKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(
        'aktiivinen' => "ei mikaan",
        'virhe' => "Vain ylläpitäjä voi tarkastella ylläpitäjän sivua.", request
    ));
}

if ( isset( $_POST['submitPoistaPuuha'] ) ) { 

   if(!empty($_POST["poistettavaPuuha"])){

	 $nimi = $_POST['poistettavaPuuha'];
	 $puuha=Puuhat::EtsiPuuhaNimella($nimi);

	 if(!empty( $puuha)) {
	       Puuhat::PoistaPuuha($puuha->getId()); 
	        $_SESSION['ilmoitus'] = "Puuha poistettu onnistuneesti.";
	 	naytaNakyma('nakymat/yllapitajanSivu.php', array(
    	 	'aktiivinen' => "omaSivu"
    	 	));
	}else{
		naytaNakyma('nakymat/yllapitajanSivu.php', array(
    	 	'aktiivinen' => "omaSivu",
	 	'virhe' => "Puuhaa ei loytynyt.", request
   
		));
	}
   }else{
	naytaNakyma('nakymat/yllapitajanSivu.php', array(
    	 'aktiivinen' => "omaSivu",
	 'virhe' => "Syota poistettava puuha.", request
   
    	 ));
}
}
naytaNakyma('nakymat/yllapitajanSivu.php', array(
    'aktiivinen' => "omaSivu"
));

