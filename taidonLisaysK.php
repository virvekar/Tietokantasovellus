<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään*/
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(        
        'virhe' => "Kirjaudu sisään lisätäksesi taidon.", request
    ));
}

if ( isset( $_POST['submittaito'] ) ) { 
     $uusiTaito = new Taidot();
     $uusiTaito->setNimi($_POST['nimi']);
     $uusiTaito->setKuvaus($_POST['kuvaus']);
     $uusiTaito->setTaidonLisaysPaiva($date = date('Y-m-d'));
     $uusiTaito->setLisaaja(annaKirjautuneenId());
     $virheet=$uusiTaito->getVirheet();
     
      if (empty($virheet)) {
          	$uusiTaito->lisaaKantaan();
        	$_SESSION['ilmoitus'] = "Taito lisätty kantaan.";
                
                $sivuNumero = 1;
                $montakoTaitoaSivulla = 20;
                $taidot = Taidot::AnnaTaitoListausRajattu($montakoTaitoaSivulla,$sivuNumero);
                $lisaajaIDLista= Taidot::AnnaTaidonLisaajaListausRajattu($montakoTaitoaSivulla,$sivuNumero);
                $lisaajaLista=Henkilo::EtsiLisaajat($lisaajaIDLista);

                $taitoLkm = Taidot::lukumaara();
                $sivuja = ceil($taitoLkm / $montakoTaitoaSivulla);

		//Taito lisättiin kantaan onnistuneesti, lähetetään käyttäjä eteenpäin.
                //Käytetään naytaNakyma kutsua, koska headeria kaytettäessä ilmoitus ei näy.
        	naytaNakyma('nakymat/taidot.php', array(
    	 	   'aktiivinen' => "taidot",
                   'taidot' => $taidot,
                   'lisaajaLista' => $lisaajaLista,
                   'sivuNumero' => $sivuNumero,
                   'sivuja'=>$sivuja,
                   'montakoSivulla'=>$montakoTaitoaSivulla
    	 	));
      }else{
           $virheet = $uusiTaito->getVirheet();

        //Virheet voidaan nyt välittää näkymälle syötettyjen tietojen kera
        naytaNakyma("nakymat/taidonLisays.php", array(
            'aktiivinen' => "taidot",
            'uusiTaito' => $uusiTaito,
            'virhe' => $virheet
        ));
      }
}
naytaNakyma('nakymat/taidonLisays.php', array(
    'aktiivinen' => "taidot",
    'uusiTaito' => new Taidot()
));
