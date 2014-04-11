<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';

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

/* Katsotaan onko puuhan poistonappia painettu*/
if ( isset( $_POST['submitPoistaPuuha'] ) ) { 
    /* Katsotaan onko kenttään annettu jokin arvo*/
   if(!empty($_POST["poistettavaPuuha"])){

	 $nimi = $_POST['poistettavaPuuha'];
	 $puuha=Puuhat::EtsiPuuhaNimella($nimi);
         /* Jos puuha löytyy poistetaan se*/
	 if(!empty( $puuha)) {
	       Puuhat::PoistaPuuha($puuha->getId()); 
	        $_SESSION['ilmoitus'] = "Puuha poistettu onnistuneesti.";
	 	naytaNakyma('nakymat/yllapitajanSivu.php', array(
    	 	'aktiivinen' => "omaSivu"
    	 	));
	}else{
            /*Jos puuhaa ei löytynyt näytetään virheilmoitus*/
		naytaNakyma('nakymat/yllapitajanSivu.php', array(
    	 	'aktiivinen' => "omaSivu",
	 	'virhe' => "Puuhaa ei loytynyt.", request
   
		));
	}
   }else{
       /*Jos kenttä oli tyhjä niin annetaan virheilmoitus*/
	naytaNakyma('nakymat/yllapitajanSivu.php', array(
    	 'aktiivinen' => "omaSivu",
	 'virhe' => "Syötä poistettava puuha.", request
   
    	 ));
}
}
/* Katsotaan onko puuhaluokan poistonappia painettu*/
if ( isset( $_POST['submitPoistaPuuhaluokka'] ) ) { 
    /* Katsotaan onko kenttään annettu jokin arvo*/
   if(!empty($_POST["poistettavaPuuhaluokka"])){

	 $nimi = $_POST['poistettavaPuuhaluokka'];
	 $puuhaluokka=Puuhaluokka::AnnaPuuhaLuokanID($nimi);
         error_log(print_r($puuhaluokka, TRUE));
         
         /* Jos puuhaluokka löytyy poistetaan se*/
	 if(!empty( $puuhaluokka)) {
	       Puuhaluokka::PoistaPuuhaluokka($puuhaluokka); 
	        $_SESSION['ilmoitus'] = "Puuhaluokka poistettu onnistuneesti.";
	 	naytaNakyma('nakymat/yllapitajanSivu.php', array(
    	 	'aktiivinen' => "omaSivu"
    	 	));
	}else{
            /*Jos puuhaluokkaa ei löytynyt annetaan virheilmoitus*/
		naytaNakyma('nakymat/yllapitajanSivu.php', array(
    	 	'aktiivinen' => "omaSivu",
	 	'virhe' => "Puuhaluokkaa ei loytynyt.", request
   
		));
	}
   }else{
       /*Jos kenttä oli tyhjä annetaan virheilmoitus*/
	naytaNakyma('nakymat/yllapitajanSivu.php', array(
    	 'aktiivinen' => "omaSivu",
	 'virhe' => "Syötä poistettava puuhaluokka.", request
   
    	 ));
}
}

/* Katsotaan onko taidon poistonappia painettu*/
if ( isset( $_POST['submitPoistaTaito'] ) ) { 
    /* Katsotaan onko kenttään annettu jokin arvo*/
   if(!empty($_POST["poistettavaTaito"])){

	 $nimi = $_POST['poistettavaTaito'];
	 $taito=Taidot::AnnaTaidonID($nimi);
         /* Jos taito löytyy poistetaan se*/
	 if(!empty( $taito)) {
	       Taidot::PoistaTaito($taito); 
	        $_SESSION['ilmoitus'] = "Taito poistettu onnistuneesti.";
	 	naytaNakyma('nakymat/yllapitajanSivu.php', array(
    	 	'aktiivinen' => "omaSivu"
    	 	));
	}else{
            /*Jos taitoa ei löytynyt annetaan virheilmoitus*/
		naytaNakyma('nakymat/yllapitajanSivu.php', array(
    	 	'aktiivinen' => "omaSivu",
	 	'virhe' => "Taitoa ei loytynyt.", request
   
		));
	}
   }else{
       /*Jos kenttä oli tyhjä annetaan virheilmoitus*/
	naytaNakyma('nakymat/yllapitajanSivu.php', array(
    	 'aktiivinen' => "omaSivu",
	 'virhe' => "Syötä poistettava taito.", request
   
    	 ));
}
}

/*Jos mitään nappia ei ole painettu näytetään sivu normaalisti*/
naytaNakyma('nakymat/yllapitajanSivu.php', array(
    'aktiivinen' => "omaSivu"
));

