<?php


function karsiHenkilo($kesto) {
    if($kesto==10){
        return array(0 , 999999); 
    }
    if($kesto==1){
        return array(1 ,1); 
    }
    if($kesto==2){
        return array(2 , 2); 
    }
    if($kesto==3){
        return array(3 , 5); 
    }
     if($kesto==4){
        return array(5, 10); 
    }
     if($kesto==5){
        return array(10 , 999999); 
    }

    
}
  /*  <option value="anyHenkilomaara" selected>-</option>
                        <option value="10">Mikä tahansa</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3-5</option>
                        <option value="4">5-10</option>
                        <option value="5">yli 10</option>*/