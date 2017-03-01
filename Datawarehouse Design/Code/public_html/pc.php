<?php
include("dbconn.php");

$query = 'SELECT tt4.p_id, pb.UID, mf.exp, AVG(mf.exp) FROM testtable4 AS tt4
	INNER JOIN testtable3 AS tt3
		ON tt4.p_id = tt3.p_id
	INNER JOIN microarray_fact AS mf
		ON tt3.s_id=mf.s_id
	INNER JOIN probe AS pb
		ON mf.pb_id = pb.pb_id
	INNER JOIN `TABLE 32` AS info
		ON pb.UID = info.`COL 1`
WHERE tt4.name = "ALL" GROUP BY tt4.p_id';
$resultALL = mysqli_query($link, $query);

while($row = mysqli_fetch_assoc($link, $query)){
    $query = 'SELECT tt4.p_id, pb.UID, mf.exp, AVG(mf.exp) FROM testtable4 AS tt4
	INNER JOIN testtable3 AS tt3
		ON tt4.p_id = tt3.p_id
	INNER JOIN microarray_fact AS mf
		ON tt3.s_id=mf.s_id
	INNER JOIN probe AS pb
		ON mf.pb_id = pb.pb_id
	INNER JOIN `TABLE 32` AS info
		ON pb.UID = info.`COL 1`
WHERE tt4.p_id="'.$row["p_id"].'" AND tt4.name = "ALL" GROUP BY tt4.p_id'
}
//$query = ;
$resultNot = mysqli_query($link, $query);

for($i = 0; $i<mysqli_num_rows($resultALL); $i++){
    $row1 = mysqli_fetch_assoc($resultALL);
    
    $row2 = mysqli_fetch_assoc($resultNot);
    //print_r($row2);
   $sol = tstat($row1["AVG(mf.exp)"], $row2["AVG(mf.exp)"], $row1["VAR_SAMP(mf.exp)"], $row2["VAR_SAMP(mf.exp)"], $row1["COUNT(mf.exp)"], $row2["COUNT(mf.exp)"]);
    echo $sol."<br>";
    
}


?>