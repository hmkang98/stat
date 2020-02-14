﻿<?php
//$p = $_POST['x'];
function Quantile($p){
$lim = pow(10,-20);
$p0  = -0.322232431088;
$p1  = -1.0;
$p2  = -0.342242088547;
$p3  = -0.0204231210245;
$p4  = -0.0000453642210148;
$q0  =  0.0993484626060;
$q1  =  0.588581570495;
$q2  =  0.531103462366;
$q3  =  0.103537752850;
$q4  =  0.0038560700634;
 if(0.5 < $p & $p < 1){
   $p = 1-$p;
   $y = sqrt(log(1/pow($p,2)));
   $xp = $y + (((($y*$p4 + $p3)*$y + $p2)*$y + $p1)*$y + $p0) /
    (((($y*$q4 + $q3)*$y + $q2)*$y +$q1)*$y + $q0);
    }
  else if ( $p == 0.5 )
   $xp = 0;
   
  else if ( $p == 1)
   $xp = 10000;
  else if ( $p == 0)
   $xp = $p0/$q0; 
  else{	
   $p = $p;	
   $y = sqrt(log(1/pow($p,2)));
   $xp = -($y + (((($y*$p4 + $p3)*$y + $p2)*$y + $p1)*$y + $p0) /
    (((($y*$q4 + $q3)*$y + $q2)*$y +$q1)*$y + $q0));
  }
  return $xp;
 }
//print $_POST['x'].'%     Percentile의 분위수는' ...Quantile($p). '입니다';
?>

