<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(        
        'virhe' => "Kirjaudu sisään muokataksesi puuhaa.", request
    ));
}
$puuhaid = (int)$_GET['puuhanid']; 
$uusiPuuha = Puuhat::EtsiPuuha($puuhaid);
$uusiPuuha-> setId($puuhaid);
 error_log(print_r( "ID ON2:", TRUE));
 error_log(print_r($puuhaid, TRUE));
 error_log(print_r($uusiPuuha, TRUE));
 
if(empty($uusiPuuha)){
    naytaNakyma('nakymat/puuhanMuokkaus.php', array(
    'aktiivinen' => "puuhat",
    'uusiPuuha' => $uusiPuuha,
    'luokat' => $luokat,
    'taidot' => $taidot,
    'virhe' => "Puuhaa ei löydy."
));
}  
$luokat = Puuhaluokka::AnnaTiedotListaukseen();
$taidot = Taidot::AnnaTaitoListaus();


/* Onko nappia painettu*/
if ( isset( $_POST['submitpuuhaMuokkaus'] ) ) { 
  
   /* Tarkistetaan onko luokkaa annettu ja miten se on annettu*/
   if(!empty($_POST["luokkasailio"])){
	 $valittuLuokka = $_POST['luokkasailio'];
   }elseif(!empty($_POST["luokka"])){
	$luokanNimi=$_POST["luokka"];
    	$valittuLuokka=Puuhaluokka::AnnaPuuhaLuokanID($luokanNimi);
   }
/* Tarkistetaan onko paikkaa annettu ja miten se on annettu*/
   if(!empty($_POST["paikka"])){
	 $paikka = $_POST['paikka'];
   }elseif(!empty($_POST["paikkasailio"])){
	$paikka=$_POST["paikkasailio"];
    	
   }

error_log(print_r("taalla ollaan!4", TRUE)); 

   /*Ottaa ajan*/
 if(!empty($_POST["paiva"]) && !empty($_POST["kellonaika"])){
	$ajankohta=date_create_from_format("j.n.Y G.i",$_POST['paiva']." ".$_POST['kellonaika']);

    	$uusiPuuha->setAjankohta($ajankohta); 
   }elseif(!empty($_POST["paiva"])){
	$ajankohta=date_create_from_format("j.n.Y G.i",$_POST['paiva']." 00.00"); 
    	$uusiPuuha->setAjankohta($ajankohta);

   }elseif(!empty($_POST["kellonaika"])){
; 
   	$ajankohta=null;
    	$uusiPuuha->setAjankohta($ajankohta); 
	}
 
    $uusiPuuha->setNimi($_POST['nimi']);
    $uusiPuuha->setKuvaus($_POST['kuvaus']);
    $uusiPuuha->setHenkilomaara($_POST['henkilomaara']);
    $uusiPuuha->setKesto($_POST['kesto']);
    $uusiPuuha->setPaikka($paikka);
    $uusiPuuha->setPuuhaluokanId($valittuLuokka);
    $uusiPuuha->setPuuhanLisaysPaiva($date = date('Y-m-d'));
    $uusiPuuha->setLisaaja(annaKirjautuneenId());
    $virheet=$uusiPuuha->getVirheet();


    /* Tarksitetaan onko puuha syötetty oikein */
    if (empty($virheet)) {
       if(empty($ajankohta)){
		$uusiPuuha->lisaaMuokkauksetKantaanEiAikaa();
        	$_SESSION['ilmoitus'] = "Muutokset tallennetu.";
        
		//Luokka lisättiin kantaan onnistuneesti, lähetetään käyttäjä eteenpäin
        	header('Location: omaSivuK.php');
   	}else{
		$uusiPuuha->lisaaMuokkauksetKantaan();
        	$_SESSION['ilmoitus'] = "Muutokset tallennetu.";
        
		//Luokka lisättiin kantaan onnistuneesti, lähetetään käyttäjä eteenpäin
        	header('Location: omaSivuK.php');
        }
    } else {
        $virheet = $uusiPuuha->getVirheet();

        //Virheet voidaan nyt välittää näkymälle syötettyjen tietojen kera
        naytaNakyma("nakymat/puuhanMuokkaus.php", array(
            'aktiivinen' => "puuhat",
            'uusiPuuha' => $uusiPuuha,
	    'luokat' => $luokat,
	     'taidot' => $taidot,
            'virhe' => $virheet
        ));
    }
}

naytaNakyma('nakymat/puuhanMuokkaus.php', array(
    'aktiivinen' => "puuhat",
    'uusiPuuha' => $uusiPuuha,
    'luokat' => $luokat,
 'taidot' => $taidot
));

