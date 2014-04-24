<?php

function OtaSivunumero(){
    $sivuNumero = (int) $_GET['sivuNumero'];

    //Sivunumero ei saa olla pienempi kuin yksi
    if ($sivuNumero < 1){
        $sivuNumero = 1;
    }
    return $sivuNumero;
}
