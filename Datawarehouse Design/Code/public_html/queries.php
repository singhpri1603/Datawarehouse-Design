<?php

if($_GET["op"] == "1"){
    $disease = $_POST["disease"];
    $name = $_POST["name"];
    
    $query = 'SELECT COUNT(*) FROM testtable4 as tt4
	INNER JOIN disease as d
		ON tt4.ds_id = d.ds_id
		WHERE d.'.$disease.' = "'.$name.'";';
    echo $query;
}

if($_GET["op"] == "2"){
    $disease = $_POST["disease"];
    $name = $_POST["name"];
    
    $query = 'SELECT DISTINCT(drug.type) FROM `testtable4` AS tt4
	INNER JOIN disease AS d
		ON tt4.ds_id=d.ds_id
	INNER JOIN clinical_fact AS cf
		ON tt4.p_id=cf.p_id
	INNER JOIN drug
		ON drug.dr_id=cf.dr_id
		WHERE d.'.$disease.' = "'.$name.'";';
    echo $query;
}

if($_GET["op"] == "3"){
    
    $query = 'SELECT tt3.p_id, tt3.s_id, tt4.name, mf.s_id, mf.exp, pb.UID
        FROM testtable3 AS tt3
        INNER JOIN testtable4 AS tt4 ON tt3.p_id = tt4.p_id
        INNER JOIN microarray_fact AS mf ON tt3.s_id = mf.s_id
        INNER JOIN probe AS pb ON mf.pb_id = pb.pb_id
        INNER JOIN gene_fact AS gf ON pb.UID = gf.UID
        WHERE tt4.name = "'.$_POST["name"].'"
        AND mf.mu_id = "'.$_POST["muid"].'"
        AND gf.cl_id = "'.$_POST["cluster"].'";';
        
    echo $query;
}



?>