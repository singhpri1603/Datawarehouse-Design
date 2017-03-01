<?php
include("dbconn.php");

//FOR disease = ALL/

$query_del='DELETE FROM `informative_not_temp2` WHERE 1';
        $result = mysqli_query($link, $query_del);
$query_first='insert into `informative_not_temp2` SELECT probe.pb_id,microarray_fact.exp,samplejoined.p_id,probe.UID FROM clinical_fact join disease on clinical_fact.ds_id=disease.ds_id left join (SELECT p_id,s_id FROM clinical_fact where clinical_fact.s_id!="null") as samplejoined on samplejoined.p_id=clinical_fact.p_id left join microarray_fact on microarray_fact.s_id=samplejoined.s_id left join probe on probe.pb_id=microarray_fact.pb_id where disease.name!="ALL" and samplejoined.s_id!="NULL" ORDER BY `probe`.`UID` ASC';
$result = mysqli_query($link, $query_first);



$query_del='DELETE FROM `informative_not_temp3` WHERE 1';
        $result = mysqli_query($link, $query_del);
$query_second='INSERT INTO informative_not_temp3
SELECT informative_not_temp2.pb_id, informative_not_temp2.exp, informative_not_temp2.p_id, informative_not_temp2.UID
FROM informative_not_temp2
RIGHT JOIN informative_genes_temp ON informative_genes_temp.gene_id = informative_not_temp2.UID';
$result = mysqli_query($link, $query_second);

$query = 'SELECT distinct informative_not_temp3.p_id FROM informative_not_temp3';
$result = mysqli_query($link, $query);

while($row1 = mysqli_fetch_assoc($result))
{
    
    $pat_id=$row1['p_id'];

    $query2 = 'SELECT pb_id,exp,p_id,UID FROM informative_not_temp3 where p_id="'.$pat_id.'" ORDER BY UID ASC';


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
  //  break;
}
    
echo '<pre>';
print_r("OLD finish");
echo '<pre>';

$new_pat_query='SELECT * FROM `TABLE 33` right join informative_genes_temp on informative_genes_temp.gene_id=`TABLE 33`.test_user_uid ORDER BY `TABLE 33`.`test_user_uid` ASC';
    $result3 = mysqli_query($link, $new_pat_query);
    $new_patient_container=array();
    $new_patient_container['pat_1']=array();
    $new_patient_container['pat_2']=array();
    $new_patient_container['pat_3']=array();
    $new_patient_container['pat_4']=array();
    $new_patient_container['pat_5']=array();
    
    $new_patient_container['pat_1']['elements']=array();
    $new_patient_container['pat_2']['elements']=array();
    $new_patient_container['pat_3']['elements']=array();
    $new_patient_container['pat_4']['elements']=array();
    $new_patient_container['pat_5']['elements']=array();
    
    
    $new_temp_sum1=0;
    $new_temp_sum2=0;
    $new_temp_sum3=0;
    $new_temp_sum4=0;
    $new_temp_sum5=0;
    
    $counter_n=0;
    
    while($row3 = mysqli_fetch_assoc($result3))
    {
        $counter_n++;
        $new_temp_sum1=$new_temp_sum1+$row3['test1'];
        $new_temp_sum2=$new_temp_sum2+$row3['test2'];
        $new_temp_sum3=$new_temp_sum3+$row3['test3'];
        $new_temp_sum4=$new_temp_sum4+$row3['test4'];
        $new_temp_sum5=$new_temp_sum5+$row3['test5'];
     $new_patient_container['pat_1']['elements'][]=$row3['test1'];   
     $new_patient_container['pat_2']['elements'][]=$row3['test2'];
     $new_patient_container['pat_3']['elements'][]=$row3['test3'];
     $new_patient_container['pat_4']['elements'][]=$row3['test4'];
     $new_patient_container['pat_5']['elements'][]=$row3['test5'];
    }
    
    $new_patient_container['pat_1']['average']=$new_temp_sum1/$counter_n;
    $new_patient_container['pat_2']['average']=$new_temp_sum2/$counter_n;
    $new_patient_container['pat_3']['average']=$new_temp_sum3/$counter_n;
    $new_patient_container['pat_4']['average']=$new_temp_sum4/$counter_n;
    $new_patient_container['pat_5']['average']=$new_temp_sum5/$counter_n;
    
    $r_of_a=array();
    $query_del='DELETE FROM rb_temp WHERE 1';
    $result_del = mysqli_query($link, $query_del);
    foreach($container as $key=>$value)
    {
     $pca_temp1=pca($container[$key]['elements'],$container[$key]['average'],$new_patient_container['pat_1']['elements'],$new_patient_container['pat_1']['average']);   
     $pca_temp2=pca($container[$key]['elements'],$container[$key]['average'],$new_patient_container['pat_2']['elements'],$new_patient_container['pat_2']['average']);   
     $pca_temp3=pca($container[$key]['elements'],$container[$key]['average'],$new_patient_container['pat_3']['elements'],$new_patient_container['pat_3']['average']);   
     $pca_temp4=pca($container[$key]['elements'],$container[$key]['average'],$new_patient_container['pat_4']['elements'],$new_patient_container['pat_4']['average']);   
     $pca_temp5=pca($container[$key]['elements'],$container[$key]['average'],$new_patient_container['pat_5']['elements'],$new_patient_container['pat_5']['average']);   
     
     //$r_of_a[]=$pca_temp;
     $query_in="insert into rb_temp values ('".$pca_temp1."','".$pca_temp2."','".$pca_temp3."','".$pca_temp4."','".$pca_temp5."')";
    $result_in = mysqli_query($link, $query_in);
    }
    
    echo '<pre>';
    print_r($new_patient_container);
    echo '</pre>';
    
    
//    echo '<pre>';
//    print_r($r_of_a);
//    echo '</pre>';
    
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