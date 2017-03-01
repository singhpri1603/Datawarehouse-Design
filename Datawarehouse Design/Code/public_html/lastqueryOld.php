<?php
include("dbconn.php");

//FOR disease = ALL/
$query = 'SELECT distinct clinical_fact.p_id FROM clinical_fact join disease on clinical_fact.ds_id=disease.ds_id left join (SELECT p_id,s_id FROM clinical_fact where clinical_fact.s_id!="null") as samplejoined on samplejoined.p_id=clinical_fact.p_id left join microarray_fact on microarray_fact.s_id=samplejoined.s_id left join probe on probe.pb_id=microarray_fact.pb_id left join gene_fact on gene_fact.UID=probe.UID where disease.name="ALL" and gene_fact.go_id="7154"';

$result = mysqli_query($link, $query);
//echo $result;

$container=array();

while($row1 = mysqli_fetch_assoc($result))
{
    
    $pat_id=$row1['p_id'];
    $query2 = 'SELECT exp FROM clinical_fact join disease on clinical_fact.ds_id=disease.ds_id left join (SELECT p_id,s_id FROM clinical_fact where clinical_fact.s_id!="null") as samplejoined on samplejoined.p_id=clinical_fact.p_id left join microarray_fact on microarray_fact.s_id=samplejoined.s_id left join probe on probe.pb_id=microarray_fact.pb_id left join gene_fact on gene_fact.UID=probe.UID where disease.name="ALL" and gene_fact.go_id="7154" AND clinical_fact.p_id="'.$pat_id.'" ORDER BY probe.pb_id ASC';
//    $query2 = 'SELECT exp
//FROM `testtable3` AS tt3
//INNER JOIN `testtable4` AS tt4 ON tt3.p_id = tt4.p_id
//INNER JOIN microarray_fact AS mf ON tt3.s_id = mf.s_id
//INNER JOIN probe ON probe.pb_id = mf.pb_id
//INNER JOIN gene_fact AS gf ON gf.UID = probe.UID
//WHERE tt4.name != "ALL"
//AND tt3.p_id="'.$pat_id.'"
//AND gf.go_id = "0007154"
//';

    $result2 = mysqli_query($link, $query2);
    
    
    $container[$pat_id]=array();
    $container[$pat_id]['elements']=array();
    $tempsum=0;
    $count=0;
 while($row2 = mysqli_fetch_assoc($result2))
{
     $count++;
     $tempsum=$tempsum+$row2['exp'];
     $container[$pat_id]['elements'][]=$row2['exp'];

}   
    
    $container[$pat_id]['average']=$tempsum/$count;
    $container[$pat_id]['count']=$count;
    //break;
}


echo 'test'; 
echo '<pre>'; 
    print_r($container);
    echo '</pre>';
    
    
    $container_keys = array_keys($container);
            echo '<pre>'; 
    print_r($container_keys);
    echo '</pre>';
    
    
//echo $newArray[0];
    
    $all_disease_pca_among_each=0;
    
    for ($out=0;$out<sizeof($container);$out++)
    {
//        echo '<pre>'; 
//        echo $out;
        for ($inn=$out+1;$inn<sizeof($container);$inn++)
        {
            $returned_pca=pca($container[$container_keys[$inn]]['elements'],$container[$container_keys[$inn]]['average'],$container[$container_keys[$out]]['elements'],$container[$container_keys[$out]]['average']);            
            
                echo '<pre>'; 
    print_r($returned_pca);
    echo '</pre>';
            
            
            $all_disease_pca_among_each=$all_disease_pca_among_each+$returned_pca;
        }
    
    }
            
    
    
             //$returned_pca=pca(array(1,2,3,4,1,3,4,2),2.5,array(1,2,3,4,1,2,3,4),2.5);            
    echo 'result';         
//    echo '<pre>'; 
//    print_r($returned_pca);
//    echo '</pre>';
    echo '<pre>'; 
    print_r($all_disease_pca_among_each);
    echo '</pre>';
    $div=(sizeof($container)*(sizeof($container)-1))/2;
    echo '<pre>'; 
    print_r("div by ".$div);
    echo '</pre>';
    
    echo '<pre>'; 
    print_r($all_disease_pca_among_each/$div);
    echo '</pre>';
    
//print_r();
//
//$mean1 = $row1["AVG( mf.exp )"];
//
//$var1 = $row1["VAR_SAMP( mf.exp )"];
//
//$n1 = $row1["COUNT( mf.exp )"];
//
//print_r($row1);
//echo"<br>";
////FOR disease != ALL
//$query = 'SELECT AVG( mf.exp ) , VAR_SAMP( mf.exp ) , COUNT( mf.exp ) 
//FROM `testtable3` AS tt3
//INNER JOIN `testtable4` AS tt4 ON tt3.p_id = tt4.p_id
//INNER JOIN microarray_fact AS mf ON tt3.s_id = mf.s_id
//INNER JOIN probe ON probe.pb_id = mf.pb_id
//INNER JOIN gene_fact AS gf ON gf.UID = probe.UID
//WHERE tt4.name != "ALL"
//AND gf.go_id = "0007154"
//';
//
//
//$result = mysqli_query($link, $query);
//$row2 = mysqli_fetch_assoc($result);
//$mean2 =  $row2["AVG( mf.exp )"];
//$var2 =  $row2["VAR_SAMP( mf.exp )"];
//$n2 =  $row2["COUNT( mf.exp )"];
//print_r($row2);
//echo"<br>";
//
//$var12 = (($n1-1)*$var1 + ($n2-1)*$var2)/($n1+$n2-2);
//echo "var12 = ".$var12;
//
//echo "<br>";
//
//echo "t = ".abs($mean1-$mean2)/sqrt($var12*(1/$n1 + 1/$n2));
//

    function pca($a,$a_mean,$b,$b_mean)
    {

        $uppersum=0;
        $lowersum_a=0;
        $lowersum_b=0;
        $lowersum=0;
        for($i=0;$i<sizeof($a);$i++)
        {
            $uppersum=$uppersum+(($a[$i]-($a_mean))*($b[$i]-$b_mean));
                        echo '<pre>'; 
    
            $lowersum_a=$lowersum_a+pow(($a[$i]-$a_mean),2);
            $lowersum_b=$lowersum_b+pow(($b[$i]-$b_mean),2);
                    
        }
       
        $lowersum=sqrt($lowersum_a)*sqrt($lowersum_b);
        $ans=$uppersum/$lowersum;
//    echo '<pre>'; 
//    print_r($ans);
//    echo '</pre>';
        return $ans;
//return 1;        
    }
    
    

?>