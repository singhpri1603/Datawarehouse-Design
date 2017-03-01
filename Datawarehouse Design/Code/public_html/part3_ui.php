<?php
include("dbconn.php");

$name = "ALL";
$p_limit=0.01;
if(isset($_GET["name"])){
    $name = $_GET["name"];
}
if(isset($_GET["p_limit"])){
    $p_limit = $_GET["p_limit"];
}

//FOR disease = ALL/
//$query_aml = 'SELECT distinct probe.uid FROM clinical_fact join disease on clinical_fact.ds_id=disease.ds_id left join (SELECT p_id,s_id FROM clinical_fact where clinical_fact.s_id!="null") as samplejoined on samplejoined.p_id=clinical_fact.p_id left join microarray_fact on microarray_fact.s_id=samplejoined.s_id left join probe on probe.pb_id=microarray_fact.pb_id where disease.name="AML"';
$query_all = 'SELECT probe.UID,AVG( microarray_fact.exp ) , VAR_SAMP( microarray_fact.exp ) , COUNT( microarray_fact.exp ) FROM clinical_fact join disease on clinical_fact.ds_id=disease.ds_id left join (SELECT p_id,s_id FROM clinical_fact where clinical_fact.s_id!="null") as samplejoined on samplejoined.p_id=clinical_fact.p_id left join microarray_fact on microarray_fact.s_id=samplejoined.s_id left join probe on probe.pb_id=microarray_fact.pb_id where disease.name="'.$name.'" and samplejoined.s_id!="NULL" group by probe.UID';
$result = mysqli_query($link, $query_all);

$contain_all=array();

while($row1 = mysqli_fetch_assoc($result))
{
    $contain_all[$row1['UID']]=array();
   
    $contain_all[$row1['UID']]['ave']=$row1["AVG( microarray_fact.exp )"];
            $contain_all[$row1['UID']]['var']=$row1["VAR_SAMP( microarray_fact.exp )"];
            $contain_all[$row1['UID']]['count']=$row1["COUNT( microarray_fact.exp )"];
}
$query_notall = 'SELECT probe.UID,AVG( microarray_fact.exp ) , VAR_SAMP( microarray_fact.exp ) , COUNT( microarray_fact.exp ) FROM clinical_fact join disease on clinical_fact.ds_id=disease.ds_id left join (SELECT p_id,s_id FROM clinical_fact where clinical_fact.s_id!="null") as samplejoined on samplejoined.p_id=clinical_fact.p_id left join microarray_fact on microarray_fact.s_id=samplejoined.s_id left join probe on probe.pb_id=microarray_fact.pb_id where disease.name!="'.$name.'" and samplejoined.s_id!="NULL" group by probe.UID';
$contain_notall=array();
$result = mysqli_query($link, $query_notall);


while($row1 = mysqli_fetch_assoc($result))
{
    $contain_notall[$row1['UID']]=array();
   
    $contain_notall[$row1['UID']]['ave']=$row1["AVG( microarray_fact.exp )"];
            $contain_notall[$row1['UID']]['var']=$row1["VAR_SAMP( microarray_fact.exp )"];
            $contain_notall[$row1['UID']]['count']=$row1["COUNT( microarray_fact.exp )"];
}

//echo '<pre>';
//echo $contain_all;
//echo '</pre>';

$query_del='DELETE FROM informative_genes_temp WHERE 1';
$result_del = mysqli_query($link, $query_del);


$container_out=array();
$testobj=new PHPExcel_Calculation_Functions;
$html_inf_table="";
$html_inf_table.="<html><table>";
$counter_inf=0;
//echo $testobj->TDIST(3.120,8,2);
foreach($contain_all as $key=>$value)
{
    //print_r($key);
//    print_r($value);
    $mean1 = $value['ave'];
$var1 = $value['var'];
$n1 = $value['count'];
    
$mean2 = $contain_notall[$key]['ave'];
$var2 = $contain_notall[$key]['var'];
$n2 = $contain_notall[$key]['count'];

$var12 = (($n1-1)*$var1 + ($n2-1)*$var2)/($n1+$n2-2);
//echo "var12 = ".$var12;
//print_r($var12);
//echo "<br>";
$t=abs($mean1-$mean2)/sqrt($var12*(1/$n1 + 1/$n2));
//echo "t = ".abs($mean1-$mean2)/sqrt($var12*(1/$n1 + 1/$n2))
//$container[$pat_uid]=$t;



$container_out[$key]=array();

    $container_out[$key]['tval']=$t;
    
    //$json = file_get_contents("http://sahildur.pythonanywhere.com/adhoc_test/?val=".$t."&degree=51");
    //$decoded=json_decode($json);
    
    $p=$testobj->TDIST(floatval($t),$n1+$n2-2,2);
    $container_out[$key]['pval']=$p;
    
    
    
    $container_out[$key]['infomative']=0;
    if(floatval($p)<$p_limit)
    {
        $html_inf_table.="<tr><td>".$key."</td></tr>";
        //$container_inf[$key]=array();
    $container_out[$key]['infomative']=1;   
    //$container_inf[$key]['pval']=$testobj->TDIST(floatval($t),51,2);
    //$container_inf[$key]['infomative']=1;
    $query_in="insert into informative_genes_temp values ('".$key."')";
    $result_in = mysqli_query($link, $query_in);
    $counter_inf++;
    }
    
    
    
    
    //break;
}

$html_inf_table.="</table></html>";


$output=array();
$output['query1']=$query_all;
$output['query2']=$query_notall;
$output['noofrows']=$counter_inf;
$output['result']=$html_inf_table;

//echo '<pre>';
//print_r($output);
//echo '</pre>';

echo json_encode($output);
//echo $result;
//
//$container=array();
//$counter_p=0;
//while($row1 = mysqli_fetch_assoc($result))
//{
//echo "<pre>";
//$counter_p++;
//echo $counter_p;
//if($counter_p>100)
//{break;}
//    $pat_uid=$row1['uid'];
//    $query_all = 'SELECT AVG( microarray_fact.exp ) , VAR_SAMP( microarray_fact.exp ) , COUNT( microarray_fact.exp ) FROM clinical_fact join disease on clinical_fact.ds_id=disease.ds_id left join (SELECT p_id,s_id FROM clinical_fact where clinical_fact.s_id!="null") as samplejoined on samplejoined.p_id=clinical_fact.p_id left join microarray_fact on microarray_fact.s_id=samplejoined.s_id left join probe on probe.pb_id=microarray_fact.pb_id where disease.name="AML" and probe.uid="'.$pat_uid.'"';
//    $query_aml = 'SELECT AVG( microarray_fact.exp ) , VAR_SAMP( microarray_fact.exp ) , COUNT( microarray_fact.exp ) FROM clinical_fact join disease on clinical_fact.ds_id=disease.ds_id left join (SELECT p_id,s_id FROM clinical_fact where clinical_fact.s_id!="null") as samplejoined on samplejoined.p_id=clinical_fact.p_id left join microarray_fact on microarray_fact.s_id=samplejoined.s_id left join probe on probe.pb_id=microarray_fact.pb_id where disease.name!="ALL" and samplejoined.s_id!="NULL"  and probe.uid="'.$pat_uid.'"';
//
//   // echo "<pre>";
//    $result_all = mysqli_query($link, $query_all);
//    $row1 = mysqli_fetch_assoc($result_all);
//$mean1 = $row1["AVG( microarray_fact.exp )"];
//$var1 = $row1["VAR_SAMP( microarray_fact.exp )"];
//$n1 = $row1["COUNT( microarray_fact.exp )"];
//   // print_r($row1);
//    
//    $result_aml = mysqli_query($link, $query_aml);
//    $row2 = mysqli_fetch_assoc($result_aml);
//$mean2 =  $row2["AVG( microarray_fact.exp )"];
//$var2 =  $row2["VAR_SAMP( microarray_fact.exp )"];
//$n2 =  $row2["COUNT( microarray_fact.exp )"];
////print_r($row2);
//$var12 = (($n1-1)*$var1 + ($n2-1)*$var2)/($n1+$n2-2);
////echo "var12 = ".$var12;
////print_r($var12);
////echo "<br>";
//$t=abs($mean1-$mean2)/sqrt($var12*(1/$n1 + 1/$n2));
////echo "t = ".abs($mean1-$mean2)/sqrt($var12*(1/$n1 + 1/$n2))
//$container[$pat_uid]=$t;
////break;
//}


//    echo 'test'; 
//    echo '<pre>'; 
//    print_r($container_out);
//    echo '</pre>';
    
//    
//    $container_keys = array_keys($container);
//            echo '<pre>'; 
//    print_r($container_keys);
//    echo '</pre>';
//    
//    
////echo $newArray[0];
//    
//    $all_disease_pca_among_each=0;
//    
//    for ($out=0;$out<sizeof($container);$out++)
//    {
////        echo '<pre>'; 
////        echo $out;
//        for ($inn=$out+1;$inn<sizeof($container);$inn++)
//        {
//            $returned_pca=pca($container[$container_keys[$inn]]['elements'],$container[$container_keys[$inn]]['average'],$container[$container_keys[$out]]['elements'],$container[$container_keys[$out]]['average']);            
//            
//                echo '<pre>'; 
//    print_r($returned_pca);
//    echo '</pre>';
//            
//            
//            $all_disease_pca_among_each=$all_disease_pca_among_each+$returned_pca;
//        }
//    
//    }
//            
//    
//    
//             //$returned_pca=pca(array(1,2,3,4,1,3,4,2),2.5,array(1,2,3,4,1,2,3,4),2.5);            
//    echo 'result';         
////    echo '<pre>'; 
////    print_r($returned_pca);
////    echo '</pre>';
//    echo '<pre>'; 
//    print_r($all_disease_pca_among_each);
//    echo '</pre>';
//    $div=(sizeof($container)*(sizeof($container)-1))/2;
//    echo '<pre>'; 
//    print_r("div by ".$div);
//    echo '</pre>';
//    
//    echo '<pre>'; 
//    print_r($all_disease_pca_among_each/$div);
//    echo '</pre>';
//    
////print_r();
////
////$mean1 = $row1["AVG( mf.exp )"];
////
////$var1 = $row1["VAR_SAMP( mf.exp )"];
////
////$n1 = $row1["COUNT( mf.exp )"];
////
////print_r($row1);
////echo"<br>";
//////FOR disease != ALL
////$query = 'SELECT AVG( mf.exp ) , VAR_SAMP( mf.exp ) , COUNT( mf.exp ) 
////FROM `testtable3` AS tt3
////INNER JOIN `testtable4` AS tt4 ON tt3.p_id = tt4.p_id
////INNER JOIN microarray_fact AS mf ON tt3.s_id = mf.s_id
////INNER JOIN probe ON probe.pb_id = mf.pb_id
////INNER JOIN gene_fact AS gf ON gf.UID = probe.UID
////WHERE tt4.name != "ALL"
////AND gf.go_id = "0007154"
////';
////
////
////$result = mysqli_query($link, $query);
////$row2 = mysqli_fetch_assoc($result);
////$mean2 =  $row2["AVG( mf.exp )"];
////$var2 =  $row2["VAR_SAMP( mf.exp )"];
////$n2 =  $row2["COUNT( mf.exp )"];
////print_r($row2);
////echo"<br>";
////
////$var12 = (($n1-1)*$var1 + ($n2-1)*$var2)/($n1+$n2-2);
////echo "var12 = ".$var12;
////
////echo "<br>";
////
////echo "t = ".abs($mean1-$mean2)/sqrt($var12*(1/$n1 + 1/$n2));
////
//
//    function pca($a,$a_mean,$b,$b_mean)
//    {
//
//        $uppersum=0;
//        $lowersum_a=0;
//        $lowersum_b=0;
//        $lowersum=0;
//        for($i=0;$i<sizeof($a);$i++)
//        {
//            $uppersum=$uppersum+(($a[$i]-($a_mean))*($b[$i]-$b_mean));
//                        echo '<pre>'; 
//    
//            $lowersum_a=$lowersum_a+pow(($a[$i]-$a_mean),2);
//            $lowersum_b=$lowersum_b+pow(($b[$i]-$b_mean),2);
//                    
//        }
//       
//        $lowersum=sqrt($lowersum_a)*sqrt($lowersum_b);
//        $ans=$uppersum/$lowersum;
////    echo '<pre>'; 
////    print_r($ans);
////    echo '</pre>';
//        return $ans;
////return 1;        
//    }
//    
//    

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


//$list = array
//(
//"Peter,Griffin,Oslo,Norway",
//"Glenn,Quagmire,Oslo,Norway",
//);

//$file = fopen("contacts.csv","w");
//
//foreach ($container_out as $key=>$line)
//  {
//    $hmm=$key.",".$line;
//    //$hmm="sahil,sdasa";
//    print_r($key);
//    echo '<pre>';
//    print_r($line);
//    echo '<pre>';
//    print_r($hmm);
//    //break;
//  fputcsv($file,explode(',',$hmm));
//  }
//
//fclose($file); 

//<!--//$aa=new PHPExcel_Calculation_Functions();
//$pval=get_t_p(3.120,8,1);
//echo $pval;
//function get_t_p($t, $df){
//  return stats_cdf_t($t, $df, 1);
//}-->

?>