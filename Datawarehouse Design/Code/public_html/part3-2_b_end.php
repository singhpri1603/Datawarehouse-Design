<?php
include("dbconn.php");

//FOR disease = ALL/

$pat_testers_ra=array();
$pat_testers_ra[]='ra_test1';
$pat_testers_ra[]='ra_test2';
$pat_testers_ra[]='ra_test3';
$pat_testers_ra[]='ra_test4';
$pat_testers_ra[]='ra_test5';

$pat_testers_rb=array();
$pat_testers_rb[]='rb_test1';
$pat_testers_rb[]='rb_test2';
$pat_testers_rb[]='rb_test3';
$pat_testers_rb[]='rb_test4';
$pat_testers_rb[]='rb_test5';

for($k=0;$k<5;$k++)
{
$query_ra = 'SELECT AVG( '.$pat_testers_ra[$k].' ) as avg , VAR_SAMP( '.$pat_testers_ra[$k].' ) as var, COUNT( '.$pat_testers_ra[$k].' ) as cnt from ra_temp';
$result_ra = mysqli_query($link, $query_ra);

$value1 = mysqli_fetch_assoc($result_ra);
$mean1 = $value1['avg'];
$var1 = $value1['var'];
$n1 = $value1['cnt'];
        
$query_rb = 'SELECT AVG( '.$pat_testers_rb[$k].' ) as avg , VAR_SAMP( '.$pat_testers_rb[$k].' ) as var, COUNT( '.$pat_testers_rb[$k].' ) as cnt from rb_temp';
$result_rb = mysqli_query($link, $query_rb);

   $value2 = mysqli_fetch_assoc($result_rb);
$mean2 = $value2['avg'];
$var2 = $value2['var'];
$n2 = $value2['cnt'];

$var12 = (($n1-1)*$var1 + ($n2-1)*$var2)/($n1+$n2-2);
//echo "var12 = ".$var12;
//print_r($var12);
//echo "<br>";
$t=abs($mean1-$mean2)/sqrt($var12*(1/$n1 + 1/$n2));

$testobj=new PHPExcel_Calculation_Functions;
$p=$testobj->TDIST(floatval($t),$n1+$n2-2,2);

echo '<pre>';
print_r($p);
echo '</pre>';

echo '<pre>';
print_r($p<0.01?"classfied as ALL":"NOT classfied as ALL");
echo '</pre>';
    
    
    
}
             


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