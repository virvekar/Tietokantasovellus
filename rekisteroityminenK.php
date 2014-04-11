<?php
require_once 'tietokanta/kirjastot/nakymakutsut.php';

require_once 'tietokanta/kirjastot/tietokantayhteys.php';

/*Tähän tulee toiminnallisuus rekisteröitymiseen*/

naytaNakyma('nakymat/rekisteroityminen.php', array(
    'aktiivinen' => "ei mikaan"
));
