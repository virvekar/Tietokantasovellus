<?php

function OnkoKirjautunut(){
    session_start();
  if (isset($_SESSION['kirjautunut'])) {
    return true;
  }
  return false;
}

