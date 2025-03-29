<?php 

function ___mc__calc_distance ($originLat, $originLng, $destinationLat, $destinationLng) {
    $R = 6371; // km
    $dLat = ($destinationLat-$originLat) * M_PI / 180;
    $dLng = ($destinationLng-$originLng) * M_PI / 180;
    $dLat1 = ($originLat) * M_PI / 180;
    $dLat2 = ($destinationLat) * M_PI / 180;
  
    $a = sin($dLat/2) * sin($dLat/2) + sin($dLng/2) * sin($dLng/2) * cos($dLat1) * cos($dLat2); 
    $c = 2 * atan2(sqrt($a), sqrt(1-$a)); 
    $distance = round($R * $c);
    return $distance;
}
