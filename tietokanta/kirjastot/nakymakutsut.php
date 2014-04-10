<?php
require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';

function naytaPohjaNakyma($sivu) {
    require '/home/virvemaa/htdocs/Tietokantasovellus/nakymat/pohja.php';
    exit();
}

  
  /* Näyttää näkymätiedoston ja lähettää sille muuttujat */
  function naytaNakyma($sivu, $data = array()) {
    $data = (object)$data;
    require '/home/virvemaa/htdocs/Tietokantasovellus/nakymat/pohja.php';
    require '/home/virvemaa/htdocs/Tietokantasovellus/nakymat/virhePohja.php';
    exit();
  }
  
  function naytaNakymaPuuhatSivulle(){
      $sivuNumero = 1;
        $montakoLuokkaaSivulla = 20;

//Kysytään mallilta Luokkia sivulla $sivu, 
        $luokat = Puuhaluokka::AnnaTiedotListaukseetRajattu($montakoLuokkaaSivulla, $sivuNumero);

//Luokkien kokonaislukumäärä haetaan, jotta tiedetään montako sivua kissoja kokonaisuudessa on:
        $luokkaLkm = Puuhaluokka::lukumaara();
        $sivuja = ceil($luokkaLkm / $montakoLuokkaaSivulla);

        $sarakeMontako = Puuhaluokka::AnnaSarakeMontakoPuuhaaLuokassa($luokat);
        $sarakeViimeisinLisaysPaiva = Puuhaluokka::AnnaSarakeViimeisinLisaysPaiva($luokat);
        

           
            //Luokka lisättiin kantaan onnistuneesti, lähetetään käyttäjä eteenpäin
            //Käytetään naytaNakyma kutsua, koska headeria kaytettäessä ilmoitus ei näy.
            naytaNakyma('nakymat/puuhat.php', array(
            'aktiivinen' => "puuhat",
            'luokat' => $luokat,
            'sarakeMontako' => $sarakeMontako,
            'sarakePaiva' => $sarakeViimeisinLisaysPaiva,
            'sivuNumero' => $sivuNumero,
            'sivuja'=>$sivuja,
            'montakoSivulla'=>$montakoLuokkaaSivulla
                    ));
  }
  

