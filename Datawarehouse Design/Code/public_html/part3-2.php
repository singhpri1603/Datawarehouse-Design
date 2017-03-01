<?php
include("dbconn.php");

//FOR disease = ALL/
$query = 'SELECT distinct samplejoined.p_id FROM clinical_fact join disease on clinical_fact.ds_id=disease.ds_id left join (SELECT p_id,s_id FROM clinical_fact where clinical_fact.s_id!="null") as samplejoined on samplejoined.p_id=clinical_fact.p_id left join microarray_fact on microarray_fact.s_id=samplejoined.s_id left join probe on probe.pb_id=microarray_fact.pb_id where disease.name="ALL" and samplejoined.s_id!="NULL"';
$result = mysqli_query($link, $query);

while($row1 = mysqli_fetch_assoc($result))
{
    
    $pat_id=$row1['p_id'];

    $query2 = 'SELECT probe.pb_id,microarray_fact.exp,samplejoined.p_id,probe.UID FROM clinical_fact join disease on clinical_fact.ds_id=disease.ds_id left join (SELECT p_id,s_id FROM clinical_fact where clinical_fact.s_id!="null") as samplejoined on samplejoined.p_id=clinical_fact.p_id left join microarray_fact on microarray_fact.s_id=samplejoined.s_id left join probe on probe.pb_id=microarray_fact.pb_id right join `informative_genes_temp` on `informative_genes_temp`.`gene_id`=probe.UID where disease.name="ALL" and samplejoined.s_id!="NULL" and samplejoined.p_id="'.$pat_id.'" ORDER BY `probe`.`UID` ASC';


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
    
//echo '<pre>';
//print_r($container);
//echo '<pre>';

$new_pat_query='SELECT test_user_uid,avg FROM `TABLE 33` right join `informative_genes_temp` on `informative_genes_temp`.`gene_id`=`TABLE 33`.test_user_uid ORDER BY `TABLE 33`.`test_user_uid` ASC';
    $result3 = mysqli_query($link, $new_pat_query);
    $new_patient_container=array();
    $new_patient_container['elements']=array();
    $new_temp_sum=0;
    $counter_n=0;
    while($row3 = mysqli_fetch_assoc($result3))
    {
        $counter_n++;
        $new_temp_sum=$new_temp_sum+$row3['avg'];
     $new_patient_container['elements'][]=$row3['avg'];   
    }
    
    $new_patient_container['average']=$new_temp_sum/$counter_n;
    
    $r_of_a=array();
    
    $query_del='DELETE FROM ra_temp WHERE 1';
$result_del = mysqli_query($link, $query_del);

    foreach($container as $key=>$value)
    {
        $pca_temp=pca($container[$key]['elements'],$container[$key]['average'],$new_patient_container['elements'],$new_patient_container['average']);   
     $r_of_a[]=$pca_temp;
     $query_in="insert into ra_temp values ('".$pca_temp."')";
    $result_in = mysqli_query($link, $query_in);
    }
    
    echo '<pre>';
    print_r($new_patient_container);
    echo '</pre>';
    
    
    echo '<pre>';
    print_r($r_of_a);
    echo '</pre>';
    
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