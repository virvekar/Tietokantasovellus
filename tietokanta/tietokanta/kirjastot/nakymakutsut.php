<?php

function naytaPohjaNakyma($sivu) {
    require '/home/virvemaa/htdocs/Tietokantasovellus/tietokanta/nakymat/pohja.php';
    exit();
}

  
  /* Näyttää näkymätiedoston ja lähettää sille muuttujat */
  function naytaNakyma($sivu, $data = array()) {
    $data = (object)$data;
    require '/home/virvemaa/htdocs/Tietokantasovellus/tietokanta/nakymat/pohja.php';
    require '/home/virvemaa/htdocs/Tietokantasovellus/tietokanta/nakymat/virhePohja.php';
    exit();
  }
