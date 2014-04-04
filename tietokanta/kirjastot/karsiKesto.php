<?php

function karsiKesto($kesto) {
    if($kesto==10){
        return array(0.0 , 999999.0); 
    }
    if($kesto==1){
        return array(0.0 , 5.0/60.0); 
    }
    if($kesto==2){
        return array(5.0/60.0 , 0.25); 
    }
    if($kesto==3){
        return array(0.25 , 0.5); 
    }
     if($kesto==4){
        return array(0.5 , 1.0); 
    }
     if($kesto==5){
        return array(1.0 , 2.0); 
    }
     if($kesto==6){
        return array(2.0 , 5.0); 
    }
     if($kesto==7){
        return array(5.0 , 12.0); 
    }
    if($kesto==8){
        return array(12.0 , 24.0); 
    }
    if($kesto==9){
        return array(12 , 999999.0); 
    }
    
}



                        /*<option value="1">alle 5 min</option>
                        <option value="2">5-15 min</option>
                        <option value="3">15-30 min</option>
                        <option value="4">30 min - 1 h</option>
                        <option value="5">1 h - 2 h</option>
                        <option value="6">2 h - 5 h</option>
                        <option value="7">5 h - 12 h</option>
                        <option value="8">12 h - 1 vrk</option>
                        <option value="9">yli 1 vrk</option>*/