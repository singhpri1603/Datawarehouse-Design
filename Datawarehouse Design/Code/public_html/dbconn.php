<?php
$servername = "79.170.40.235";
$username = "cl22-cse601";
$password = "N-.HRmJ-x";

$link = mysqli_connect($servername, $username, $password, $username);

if(mysqli_connect_errno()){
    echo "Unable to connect";
    exit();
    
}

function tstat($mean1, $mean2, $var1, $var2, $n1, $n2){
    $var12 = (($n1-1)*$var1 + ($n2-1)*$var2)/($n1+$n2-2);
    //echo "var12 = ".$var12;

    $sol = "t = ".abs($mean1-$mean2)/sqrt($var12*(1/$n1 + 1/$n2));
    return $sol;
}
?>