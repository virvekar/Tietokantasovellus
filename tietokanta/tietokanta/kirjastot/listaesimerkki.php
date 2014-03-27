<?php
//require_once sisällyttää annetun tiedoston vain kerran
require_once "tietokantayhteys.php"; 
require_once "henkilo.php";

//Lista asioista array-tietotyyppiin laitettuna:
$lista = Henkilo::etsiKaikkiKayttajat();
?><!DOCTYPE HTML>
<html>
  <head><title>Otsikko</title></head>
  <body>
    <h1>Listaelementtitesti</h1>
    <ul>
    <?php foreach($lista as $asia) { ?>
      <li><?php echo $asia; ?></li>
    <?php } ?>
    </ul>
  </body>
</html>
