<?php

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
  

