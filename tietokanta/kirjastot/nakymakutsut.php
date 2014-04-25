<?php

require_once 'tietokanta/kirjastot/mallit/Puuhaluokka.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/mallit/Taidot.php';
require_once 'tietokanta/kirjastot/mallit/Puuhat.php';
require_once 'tietokanta/kirjastot/mallit/Suosikit.php';
require_once 'tietokanta/kirjastot/mallit/OmatTaidot.php';
require_once 'tietokanta/kirjastot/mallit/PuuhaTaidot.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';


/* Funktio joka näyttää pelkän pohjan */

function naytaPohjaNakyma($sivu) {
    require '/home/virvemaa/htdocs/Tietokantasovellus/nakymat/pohja.php';
    exit();
}

/* Näyttää näkymätiedoston ja lähettää sille muuttujat */

function naytaNakyma($sivu, $data = array()) {
    $data = (object) $data;
    require '/home/virvemaa/htdocs/Tietokantasovellus/nakymat/virhePohja.php';
    require '/home/virvemaa/htdocs/Tietokantasovellus/nakymat/pohja.php';

    exit();
}

/* Hakee tarvittavat tiedot ja näyttää puuhat näkymän */

function naytaNakymaPuuhatSivulle($sivuNumero) {

    $montakoLuokkaaSivulla = 20;

    //Kysytään mallilta Luokkia sivulla $sivu, 
    $luokat = Puuhaluokka::AnnaTiedotListaukseetRajattu($montakoLuokkaaSivulla, $sivuNumero);

    //Luokkien kokonaislukumäärä haetaan, jotta tiedetään montako sivua luokkia kokonaisuudessa on:
    $luokkaLkm = Puuhaluokka::lukumaara();
    $sivuja = ceil($luokkaLkm / $montakoLuokkaaSivulla);

    /* Etsii tiedon montako puuhaa on missäkin luokassa */
    $sarakeMontako = Puuhaluokka::AnnaSarakeMontakoPuuhaaLuokassa($luokat);
    /* Hakee kustakin puuhaluokasta päivän jolloin siihen on viimeksi lisätty puuha */
    $sarakeViimeisinLisaysPaiva = Puuhaluokka::AnnaSarakeViimeisinLisaysPaiva($luokat);

    /* Jos yhtään puuhaa ei löytynyt näytetään virheilmoitus */
    if (empty($luokat)) {
        naytaNakyma('nakymat/puuhat.php', array(
            'aktiivinen' => "puuhat",
            'virhe' => "Yhtään puuhaluokkaa ei ole"
        ));
    }

    /* Välitetään tiedot näkymälle */
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

/* Hakee tarvittavat tiedot ja näyttää luokanPuuhat näkymän */

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

/* Hakee tarvittavat tiedot ja näyttää taidot näkymän */

function naytaNakymaTaidotSivulle($sivuNumero) {

    $montakoTaitoaSivulla = 20;
    /* Haetaan tarvittavat taidot */
    $taidot = Taidot::AnnaTaitoListausRajattu($montakoTaitoaSivulla, $sivuNumero);
    /* Haetaan niiden käyttäjien id:t ketkä ovat lisäännet taitoja */
    $lisaajaIDLista = Taidot::AnnaTaidonLisaajaListausRajattu($montakoTaitoaSivulla, $sivuNumero);
    /* Haetaan niiden käyttäjien nimet ketkä ovat lisäännet taitoja */
    $lisaajaLista = Henkilo::EtsiLisaajat($lisaajaIDLista);

    $taitoLkm = Taidot::lukumaara();
    $sivuja = ceil($taitoLkm / $montakoTaitoaSivulla);

    /* Jos taitoja ei löytynyt näytetään virheilmoitus */
    if (empty($taidot)) {
        naytaNakyma('nakymat/taidot.php', array(
            'aktiivinen' => "taidot",
            'virhe' => "Yhtään taitoa ei ole."
        ));
    }

    /* Välitetään tiedot näkymälle */
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

/* Haetaan käyttäjän lisäämät puuhat ja taidot tietokannasta sekä kyttäjän hallitsemat
 * taidot ja hänen suosikkipuuhansa ja väliteään ne näkymän
  näyttävälle funktiolle */

function naytaNakymaOmalleSivulle() {

   /*Haetaan käyttäjän suosikkipuuhien id:t tietokannasta*/
    $suosikkiPuuhaIDt = Suosikit::AnnaKayttajanSuosikit(annaKirjautuneenId());

    /* Haetaan käyttäjän osaamien taitojen id:t tietokannasta */
    $osattujenTaitojenIDt = OmatTaidot::AnnaKayttajanTaidot(annaKirjautuneenId());

    /* Haetaan suosikkipuuhien tiedot */
    $suosikkiPuuhat = array();
    foreach ($suosikkiPuuhaIDt as $id):
        $suosikkiPuuhat[] = Puuhat::EtsiPuuha($id);
    endforeach;

    /* Haetaan osattujen taitojen tiedot */
    $osatutTaidot = array();
    foreach ($osattujenTaitojenIDt as $id):
        $osatutTaidot[] = Taidot::EtsiTaito($id);
    endforeach;
    $omatPuuhat = Puuhat::HaePuuhatTekijalla(annaKirjautuneenId());
    $omatTaidot = Taidot::HaeTaidotTekijalla(annaKirjautuneenId());

    naytaNakyma('nakymat/omaSivu.php', array(
        'nimi' => annaKirjautuneenNimimerkki(),
        'aktiivinen' => "omaSivu",
        'omatPuuhat' => $omatPuuhat,
        'omatTaidot' => $omatTaidot,
        'suosikkiPuuhat' => $suosikkiPuuhat,
        'osatutTaidot' => $osatutTaidot
    ));
}

/* Haetaan lista käyttäjistä ja näytetään ylläpitäjän näkymä */

function naytaNakymaYllapitajanSivulle($viesti) {
    /* Haetaan lista kayttajista */
    $kayttajat = Henkilo::etsiKaikkiKayttajat();
    naytaNakyma('nakymat/yllapitajanSivu.php', array(
        'aktiivinen' => "omaSivu",
        'henkilot' => $kayttajat,
        'virhe' => $viesti, request
    ));
}

/* Näytetään näkymä kirjautumissivulle virheilmoituksella */

function naytaNakymaKirjautumisSivulleVirheella() {
    naytaNakyma('nakymat/Kirjautuminen.php', array(
        'aktiivinen' => "ei mikaan",
        'kayttaja' => new Henkilo(),
        'virhe' => "Kirjaudu sisään tarkastellaksesi tätä sivua", request
    ));
}

function naytaNakymaKirjautumisSivulle($virhe,$kayttaja) {   
    naytaNakyma('nakymat/Kirjautuminen.php', array(
         'kayttaja' => $kayttaja,
        'aktiivinen' => "ei mikaan",
        'virhe' => $virhe, request
    ));
}

/* Näytetään näkymä kirjautumissivulle ilmoituksella että vain ylläpitäjällä on pääsy
  yritetylle sivulle */

function naytaNakymaKirjautumisSivulleYllapitajaVirheella() {
    naytaNakyma('nakymat/Kirjautuminen.php', array(
        'aktiivinen' => "ei mikaan",
        'kayttaja' => new Henkilo(),
        'virhe' => "Vain ylläpitäjä voi tarkasttella tätä sivua", request
    ));
}

/* Näytetään näkymän taidonlisayssivulle  */

function naytaNakymaTaidonLisaysSivulle($uusiTaito, $tyyppi, $virhe) {
    naytaNakyma('nakymat/taidonLisays.php', array(
        'aktiivinen' => "taidot",
        'uusiTaito' => $uusiTaito,
        'virhe' => $virhe,
        'tyyppi' => $tyyppi
    ));
}

/* Nayttaa nakymän suosituksen kirjoitus sivulle */

function naytaNakymaSuosituksenKirjoitusSivulle($puuha, $suositus, $virheet, $tyyppi) {
    naytaNakyma('nakymat/suosituksenKirjoitus.php', array(
        'aktiivinen' => "ei mikaan",
        'puuha' => $puuha,
        'suositus' => $suositus,
        'virhe' => $virheet,
        'tyyppi' => $tyyppi
    ));
}

/* Nayttaa nakyman salasananvaihto sivulle */

function NaytaNakymaSalasananVaihtoSivulle($virheilmoitus) {
    naytaNakyma('nakymat/salasananVaihto.php', array(
        'aktiivinen' => "omaSivu",
        'virhe' => $virheilmoitus
    ));
}

/* Nayttaa nakyman rekisteroitymissivulle */

function NaytaNakymaRekisteroitymisSivulle($uusiHenkilo, $virheilmoitus) {
    naytaNakyma("nakymat/rekisteroityminen.php", array(
        'aktiivinen' => "ei mikaan",
        'uusiHenkilo' => $uusiHenkilo,
        'virhe' => $virheilmoitus
    ));
}

/* Nayttaa nakyman puuhan tiedot sivulle */

function NaytaNakymaPuuhanTiedotSivulle($puuha, $virheet) {
    /* Haetaan puuhaluokan nimi */
    $luokanNimi = Puuhaluokka::AnnaPuuhaLuokka($puuha->getPuuhaluokanId());

    /* Haetaan puuhaan liittyvät taidot */
    $taitojenIdt = PuuhaTaidot::AnnaPuuhanTaidot($puuha->getId());
    $taitojenNimet = Taidot::EtsiTaitojenNimet($taitojenIdt);

    /* Haetaan puuhaan liittyvät suositukset */
    $suositukset = Suositukset::AnnaSuositukset($puuha->getId());

    /* Haetaan puuhan lisaaja */
    $lisaaja = Henkilo::EtsiHenkilo($puuha->getLisaaja());
    naytaNakyma('nakymat/puuhanTiedot.php', array(
        'aktiivinen' => "puuhat",
        'puuha' => $puuha,
        'luokanNimi' => $luokanNimi,
        'lisaaja' => $lisaaja,
        'kirjautuneenid' => annaKirjautuneenId(),
        'taitojenNimet' => $taitojenNimet,
        'suositukset' => $suositukset,
        'virhe' => $virheet
    ));
}

/*Nayttaa nakyman puuhan lisays sivulle*/

function NaytaNakymaPuuhanLisaysSivulle($uusiPuuha, $tyyppi, $virhe) {

    /* Haetaan puuhaluokat ja taidot dropvalikkoja varten */
    $luokat = Puuhaluokka::AnnaTiedotListaukseen();
    $taidot = Taidot::AnnaTaitoListaus();

    naytaNakyma('nakymat/puuhanLisays.php', array(
        'aktiivinen' => "puuhat",
        'uusiPuuha' => $uusiPuuha,
        'luokat' => $luokat,
        'taidot' => $taidot,
        'virhe' => $virhe,
        'tyyppi' => $tyyppi
    ));
}

/*Nayttaa nakyman puuhaluokan muokkaussivulle*/

function NaytaNakymaPuuhaluokanLisaysSivulle($uusiLuokka, $tyyppi, $virheet) {
    naytaNakyma("nakymat/puuhaluokanLisays.php", array(
        'aktiivinen' => "puuhat",
        'uusiLuokka' => $uusiLuokka,
        'virhe' => $virheet,
        'tyyppi' => $tyyppi
    ));
}

/*Nayttaa hakunäkymän*/

function NaytaHakuNakyma($puuhat,$virhe){
    $luokat = Puuhaluokka::AnnaTiedotListaukseen();
    naytaNakyma('nakymat/haku.php', array(
        'aktiivinen' => "haku",
        'luokat' => $luokat,
        'puuhat' => $puuhat,
        'virhe' => $virhe
    ));
}