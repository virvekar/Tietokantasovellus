<?php

require_once 'tietokanta/kirjastot/nakymakutsut.php';
require_once 'tietokanta/kirjastot/tietokantayhteys.php';
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
require_once 'tietokanta/kirjastot/mallit/Henkilo.php';
require_once 'tietokanta/kirjastot/annaKirjautuneenNimimerkki.php';

/* Tarkistetaan onko käyttäjä kirjautunut sisään */
if (!OnkoKirjautunut()) {
    naytaNakyma('nakymat/Kirjautuminen.php', array(
        'virhe' => "Kirjaudu sisään vaitaaksesi salasanaa.", request
    ));
}

/* Katsotaan onko vaihtonappia painettu */
if (isset($_POST['submitvaihda'])) {
    $puuhaajaid = annaKirjautuneenId();
    /* Haetaan henkilon tiedot */

    $henkilo = Henkilo::EtsiKokoHenkilo($puuhaajaid);
    $vanhaSalasana = $_POST['vanhaSalasana'];

    /* Funktio tarkistaa vastaako annettu salasana henkilon salasanaa */
    if ($henkilo->TarkistaOnkoVanhaSalasanaOikein($vanhaSalasana)) {

        /* Koetetaan vaihtaa henkilon salsana */
        $henkilo->VaihdaSalasana($_POST['salasana'], $_POST['salasana2']);
        $virheet=$henkilo->getVirheet();
        /* Jos ei virheitä vaihdetaan salasana myös tietokantaan */
        if (empty($virheet)) {
            $henkilo->vaihdaSalasanaTietokantaan();
            $_SESSION['ilmoitus'] = "Salasana vaihdettu onnistuneesti.";

            naytaNakyma('nakymat/salasananVaihto.php', array(
                'aktiivinen' => "omaSivu"
            ));
        } else {
            /* Virheitä löytyi, näytetään virheilmoitus */
            naytaNakyma('nakymat/salasananVaihto.php', array(
                'aktiivinen' => "omaSivu",
                'virhe' => $virheet
            ));
        }
    } else {
        /* Jos annettu salasana ei vastannut henkilon salasanaa, näytetään virheilmoitus */

        naytaNakyma('nakymat/salasananVaihto.php', array(
            'aktiivinen' => "omaSivu",
            'virhe' => "Antamasi vanha salasana on väärä."
        ));
    }
}

naytaNakyma('nakymat/salasananVaihto.php', array(
    'aktiivinen' => "omaSivu"
));


