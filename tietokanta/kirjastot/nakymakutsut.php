<?php

require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';


/*Funktio joka näyttää pelkän pohjan*/
function naytaPohjaNakyma($sivu) {
    require '/home/virvemaa/htdocs/Tietokantasovellus/nakymat/pohja.php';
    exit();
}

/* Näyttää näkymätiedoston ja lähettää sille muuttujat */
function naytaNakyma($sivu, $data = array()) {
    $data = (object) $data;
    require '/home/virvemaa/htdocs/Tietokantasovellus/nakymat/pohja.php';
    require '/home/virvemaa/htdocs/Tietokantasovellus/nakymat/virhePohja.php';
    exit();
}

/*Hakee tarvittavat tiedot ja näyttää puuhat näkymän*/
function naytaNakymaPuuhatSivulle($sivuNumero) {

    $montakoLuokkaaSivulla = 20;

    //Kysytään mallilta Luokkia sivulla $sivu, 
    $luokat = Puuhaluokka::AnnaTiedotListaukseetRajattu($montakoLuokkaaSivulla, $sivuNumero);

    //Luokkien kokonaislukumäärä haetaan, jotta tiedetään montako sivua luokkia kokonaisuudessa on:
    $luokkaLkm = Puuhaluokka::lukumaara();
    $sivuja = ceil($luokkaLkm / $montakoLuokkaaSivulla);

    /*Etsii tiedon montako puuhaa on missäkin luokassa*/
    $sarakeMontako = Puuhaluokka::AnnaSarakeMontakoPuuhaaLuokassa($luokat);
    /*Hakee kustakin puuhaluokasta päivän jolloin siihen on viimeksi lisätty puuha*/
    $sarakeViimeisinLisaysPaiva = Puuhaluokka::AnnaSarakeViimeisinLisaysPaiva($luokat);

    /*Jos yhtään puuhaa ei löytynyt näytetään virheilmoitus*/
    if (empty($luokat)) {
        naytaNakyma('nakymat/puuhat.php', array(
            'aktiivinen' => "puuhat",
            'virhe' => "Yhtään puuhaluokkaa ei ole"
        ));
    }

        /*Välitetään tiedot näkymälle*/
    naytaNakyma('nakymat/puuhat.php', array(
        'aktiivinen' => "puuhat",
        'luokat' => $luokat,
        'sarakeMontako' => $sarakeMontako,
        'sarakePaiva' => $sarakeViimeisinLisaysPaiva,
        'sivuNumero' => $sivuNumero,
        'sivuja' => $sivuja,
        'montakoSivulla' => $montakoLuokkaaSivulla
    ));
}

/*Hakee tarvittavat tiedot ja näyttää luokanPuuhat näkymän*/
function naytaNakymaLuokanPuuhatSivulle($sivuNumero, $luokanid) {
    $montakoLuokkaaSivulla = 20;

    /* Etsitään oikea määrä puuhia */
    $puuhat = Puuhat::EtsiPuuhatLuokassaRajattu($luokanid, $montakoLuokkaaSivulla, $sivuNumero);
    /* Lasketaan lukumäärä */
    $puuhaLkm = Puuhat::lukumaara($luokanid);
    $sivuja = ceil($puuhaLkm / $montakoLuokkaaSivulla);

    /* Jos puuhia ei löytynyt näytetään virheilmoitus */
    if (empty($puuhat)) {
        naytaNakyma('nakymat/luokanPuuhat.php', array(
            'aktiivinen' => "puuhat",
            'virhe' => "Luokassa ei ole lainkaan puuhia."
        ));
    }

    /* Välitetään tiedot näkymälle */
    naytaNakyma('nakymat/luokanPuuhat.php', array(
        'aktiivinen' => "puuhat",
        'puuhat' => $puuhat,
        'sivuNumero' => $sivuNumero,
        'sivuja' => $sivuja,
        'montakoSivulla' => $montakoLuokkaaSivulla,
        'luokanid' => $luokanid,
        'kirjautuneenid' => annaKirjautuneenId()
    ));
}

/*Hakee tarvittavat tiedot ja näyttää taidot näkymän*/
function naytaNakymaTaidotSivulle($sivuNumero) {

    $montakoTaitoaSivulla = 20;
    /*Haetaan tarvittavat taidot*/
    $taidot = Taidot::AnnaTaitoListausRajattu($montakoTaitoaSivulla, $sivuNumero);
    /*Haetaan niiden käyttäjien id:t ketkä ovat lisäännet taitoja*/
    $lisaajaIDLista = Taidot::AnnaTaidonLisaajaListausRajattu($montakoTaitoaSivulla, $sivuNumero);
    /*Haetaan niiden käyttäjien nimet ketkä ovat lisäännet taitoja*/
    $lisaajaLista = Henkilo::EtsiLisaajat($lisaajaIDLista);

    $taitoLkm = Taidot::lukumaara();
    $sivuja = ceil($taitoLkm / $montakoTaitoaSivulla);

    /*Jos taitoja ei löytynyt näytetään virheilmoitus*/
    if (empty($taidot)) {
        naytaNakyma('nakymat/taidot.php', array(
            'aktiivinen' => "taidot",
            'virhe' => "Yhtään taitoa ei ole."
        ));
    }
    
    /*Välitetään tiedot näkymälle*/
    naytaNakyma('nakymat/taidot.php', array(
        'aktiivinen' => "taidot",
        'taidot' => $taidot,
        'lisaajaLista' => $lisaajaLista,
        'sivuNumero' => $sivuNumero,
        'sivuja' => $sivuja,
        'montakoSivulla' => $montakoTaitoaSivulla,
        'kirjautuneenid' => annaKirjautuneenId()
    ));
}

function naytaNakymaOmalleSivulle() {
    $omatPuuhat = Puuhat::HaePuuhatTekijalla(annaKirjautuneenId());
    $omatTaidot = Taidot::HaeTaidotTekijalla(annaKirjautuneenId());

    naytaNakyma('nakymat/omaSivu.php', array(
        'nimi' => annaKirjautuneenNimimerkki(),
        'aktiivinen' => "omaSivu",
        'omatPuuhat' => $omatPuuhat,
        'omatTaidot' => $omatTaidot
    ));
}
