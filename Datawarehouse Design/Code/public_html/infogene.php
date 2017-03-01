<?php
include("dbconn.php");

$query = 'SELECT probe.UID, AVG(mf.exp), VAR_SAMP(mf.exp), COUNT(mf.exp) 
 FROM probe 
	INNER JOIN microarray_fact AS mf ON
		mf.pb_id = probe.pb_id INNER JOIN testtable3 AS tt3
		ON tt3.s_id = mf.s_id
	INNER JOIN testtable4 AS tt4
		ON tt3.p_id = tt4.p_id
	WHERE tt4.name = "ALL" GROUP BY probe.UID';
$resultALL = mysqli_query($link, $query);

$query = 'SELECT probe.UID, AVG(mf.exp), VAR_SAMP(mf.exp), COUNT(mf.exp) 
 FROM probe 
	INNER JOIN microarray_fact AS mf ON
		mf.pb_id = probe.pb_id INNER JOIN testtable3 AS tt3
		ON tt3.s_id = mf.s_id
	INNER JOIN testtable4 AS tt4
		ON tt3.p_id = tt4.p_id
	WHERE tt4.name != "ALL" GROUP BY probe.UID';
$resultNot = mysqli_query($link, $query);

for($i = 0; $i<mysqli_num_rows($resultALL); $i++){
    $row1 = mysqli_fetch_assoc($resultALL);
    
    $row2 = mysqli_fetch_assoc($resultNot);
    //print_r($row2);
   $sol = tstat($row1["AVG(mf.exp)"], $row2["AVG(mf.exp)"], $row1["VAR_SAMP(mf.exp)"], $row2["VAR_SAMP(mf.exp)"], $row1["COUNT(mf.exp)"], $row2["COUNT(mf.exp)"]);
    echo $sol."<br>";
    
}


?>