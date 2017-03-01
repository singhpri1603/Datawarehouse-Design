<?php
include("dbconn.php");

$output = array();

$query = 'SELECT AVG( mf.exp ) , VAR_SAMP( mf.exp ) , COUNT( mf.exp ) 
FROM `testtable3` AS tt3
INNER JOIN `testtable4` AS tt4 ON tt3.p_id = tt4.p_id
INNER JOIN microarray_fact AS mf ON tt3.s_id = mf.s_id
INNER JOIN probe ON probe.pb_id = mf.pb_id
INNER JOIN testtable5 AS tt5 ON tt5.UID = probe.UID
WHERE tt4.name = "'.$_GET["name"].'"
AND tt5.go_id = "'.$_GET["goid"].'"
';

$output["query1"] = $query;
//echo "<p>Query 1: ".$query."</p>";

$result = mysqli_query($link, $query);
$row1 = mysqli_fetch_assoc($result);

$mean1 = $row1["AVG( mf.exp )"];

$var1 = $row1["VAR_SAMP( mf.exp )"];

$n1 = $row1["COUNT( mf.exp )"];

$output["mean1"] = $mean1;
$output["var1"] = $var1;
$output["n1"] = $n1;

//echo"<br>";

$query = 'SELECT AVG( mf.exp ) , VAR_SAMP( mf.exp ) , COUNT( mf.exp ) 
FROM `testtable3` AS tt3
INNER JOIN `testtable4` AS tt4 ON tt3.p_id = tt4.p_id
INNER JOIN microarray_fact AS mf ON tt3.s_id = mf.s_id
INNER JOIN probe ON probe.pb_id = mf.pb_id
INNER JOIN testtable5 AS tt5 ON tt5.UID = probe.UID
WHERE tt4.name != "'.$_GET["name"].'"
AND tt5.go_id = "'.$_GET["goid"].'"
';
//echo "<p>Query 1: ".$query."</p>";
$output["query2"] = $query;

$result = mysqli_query($link, $query);
$row2 = mysqli_fetch_assoc($result);
$mean2 =  $row2["AVG( mf.exp )"];
$var2 =  $row2["VAR_SAMP( mf.exp )"];
$n2 =  $row2["COUNT( mf.exp )"];

$output["mean2"] = $mean2;
$output["var2"] = $var2;
$output["n2"] = $n2;
//echo"<br>";

$var12 = (($n1-1)*$var1 + ($n2-1)*$var2)/($n1+$n2-2);

$output["var12"] = $var12;



if($n1 != 0 && $n2 != 0){
    $sqrt = sqrt($var12*(1/$n1 + 1/$n2));
    $t = abs($mean1-$mean2)/$sqrt;
    $output["t"] = $t;
} else {
    $output["t"] = "Incorrect query. N1 or N2 is zero";
}

$testobj=new PHPExcel_Calculation_Functions;
$p1=$testobj->TDIST(floatval($t),$n1+$n2-2,1);
$p2=$testobj->TDIST(floatval($t),$n1+$n2-2,2);
$output["p1"] = $p1;
$output["p2"] = $p2;
echo json_encode($output);


class PHPExcel_Calculation_Functions {
     public static function TDIST($value, $degrees, $tails) {
        $value        = self::flattenSingleValue($value);
        $degrees    = floor(self::flattenSingleValue($degrees));
        $tails        = floor(self::flattenSingleValue($tails));
 
        if ((is_numeric($value)) && (is_numeric($degrees)) && (is_numeric($tails))) {
            if (($value < 0) || ($degrees < 1) || ($tails < 1) || ($tails > 2)) {
                return self::$_errorCodes['num'];
            }
            //    tdist, which finds the probability that corresponds to a given value
            //    of t with k degrees of freedom.  This algorithm is translated from a
            //    pascal function on p81 of "Statistical Computing in Pascal" by D
            //    Cooke, A H Craven & G M Clark (1985: Edward Arnold (Pubs.) Ltd:
            //    London).  The above Pascal algorithm is itself a translation of the
            //    fortran algoritm "AS 3" by B E Cooper of the Atlas Computer
            //    Laboratory as reported in (among other places) "Applied Statistics
            //    Algorithms", editied by P Griffiths and I D Hill (1985; Ellis
            //    Horwood Ltd.; W. Sussex, England).
//            $ta = 2 / pi();
            $ta = 0.636619772367581;
            $tterm = $degrees;
            $ttheta = atan2($value,sqrt($tterm));
            $tc = cos($ttheta);
            $ts = sin($ttheta);
            $tsum = 0;
 
            if (($degrees % 2) == 1) {
                $ti = 3;
                $tterm = $tc;
            } else {
                $ti = 2;
                $tterm = 1;
            }
 
            $tsum = $tterm;
            while ($ti < $degrees) {
                $tterm *= $tc * $tc * ($ti - 1) / $ti;
                $tsum += $tterm;
                $ti += 2;
            }
            $tsum *= $ts;
            if (($degrees % 2) == 1) { $tsum = $ta * ($tsum + $ttheta); }
            $tValue = 0.5 * (1 + $tsum);
            if ($tails == 1) {
                return 1 - abs($tValue);
            } else {
                return 1 - abs((1 - $tValue) - $tValue);
            }
        }
        return self::$_errorCodes['value'];
    }
    
     	public static function flattenSingleValue($value = '') {
           while (is_array($value)) {
               $value = array_pop($value);
           }
  
           return $value;
       }  
}
?>