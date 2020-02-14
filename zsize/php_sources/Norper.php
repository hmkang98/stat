<?php // Zcdf.php for Standard normal cdf
function erf($x) {
        $pi = 3.1415927; 
        $a = (8*($pi - 3))/(3*$pi*(4 - $pi)); 
        $x2 = $x * $x; 

        $ax2 = $a * $x2; 
        $num = (4/$pi) + $ax2; 
        $denom = 1 + $ax2; 

        $inner = (-$x2)*$num/$denom; 
        $erf2 = 1 - exp($inner); 

        return sqrt($erf2); 
} 

function calculate($z) { 
        if($z < 0) { 
                return (1 - erf($z / sqrt(2)))/2; 
        } else { 
                return (1 + erf($z / sqrt(2)))/2; 
        } 
} 
?>

