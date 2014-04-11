<?php

/*Kirjataan käyttäjä ulos*/
function KirjauduUlos(){
    session_start();

//Poistetaan istunnosta merkintä kirjautuneesta käyttäjästä -> Kirjaudutaan ulos
  unset($_SESSION["kirjautunut"]);

  //Yleensä kannattaa ulkos kirjautumisen jälkeen ohjata käyttäjä kirjautumissivulle
  header('Location: kirjautuminen.php');
}