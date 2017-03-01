<?php
include("dbconn.php");
$first = true;
$names = "";
$output = array();
if(isset($_GET["ALL"])){
    if($first){
        $names.='tt4.name = "ALL"';
    } else {
        $names.='OR tt4.name = "ALL"';
    }
    $first = false;
}
if(isset($_GET["AML"])){
    if($first){
        $names.='tt4.name = "AML"';
    } else {
        $names.='OR tt4.name = "AML"';
    }
    $first = false;
}

if(isset($_GET["Breast"])){
    if($first){
        $names.='tt4.name = "Breast tumor"';
    } else {
        $names.='OR tt4.name = "Breast tumor"';
    }
    $first = false;
}
if(isset($_GET["Colon"])){
    if($first){
        $names.='tt4.name = "Colon tumor"';
    } else {
        $names.='OR tt4.name = "Colon tumor"';
    }
    $first = false;
}

if(isset($_GET["Flu"])){
    if($first){
        $names.='tt4.name = "Flu"';
    } else {
        $names.='OR tt4.name = "Flu"';
    }
    $first = false;
}


//$names='tt4.name = "ALL"OR tt4.name = "AML"OR tt4.name = "Breast tumor"OR tt4.name = "Colon tumor"';

$query = 'SELECT tt4.name, AVG(mf.exp) , COUNT(*) , SUM(mf.exp) 
FROM testtable4 AS tt4
INNER JOIN testtable3 AS tt3 ON tt4.p_id = tt3.p_id
INNER JOIN microarray_fact AS mf ON tt3.s_id = mf.s_id
INNER JOIN probe ON mf.pb_id = probe.pb_id
INNER JOIN testtable5 AS tt5 ON probe.UID = tt5.UID
WHERE tt5.go_id = "0007154"
AND (
'.$names.'
)
GROUP BY tt4.name';
//echo $query."<br>";
$output["query"] = $query;
//$query='SELECT name, AVG(exp) , COUNT(*) , SUM(exp) 
//FROM fstatdemo
//GROUP BY name
//';

$result = mysqli_query($link, $query);
$arr = array();
$N = 0;
$X = 0;
while($row = mysqli_fetch_assoc($result)){
    $newdata = array("mean"=>$row["AVG(mf.exp)"], "n" => $row["COUNT(*)"], "sum" => $row["SUM(mf.exp)"]);
    $arr[$row["name"]] = $newdata;
    $N += $row["COUNT(*)"];
    $X += $row["SUM(mf.exp)"];
}
$X = $X/$N;
//echo "X = ".$X."<br>";
$output["X"] = $X;
//echo "N = ".$N."<br>";
$output["N"] = $N;
$SSd = 0;
$SSe = 0;
foreach($arr as $key=>$value){
//    echo $key.": ";
    //print_r($value);
//    echo "<br>";
    $temp = pow($value["mean"] - $X, 2)*$value["n"];
//    echo $temp."<br>";
    $SSd += pow($value["mean"] - $X, 2)*$value["n"];
    
    computeSSe($key, $value["mean"]);
}

//echo "SSd = ".$SSd."<br>";
$output["SSd"] = $SSd;

//echo "SSe = ".$SSe."<br>";
$output["SSe"] = $SSe;
$num=(count($arr)-1);
$MSd = $SSd/(count($arr)-1);
$MSe = $SSe/($N-count($arr));
$deno=($N-count($arr));
$Fstat = $MSd/$MSe;
//echo "MSd= ".$MSd."<br>MSe= ".$MSe."<br>F= ".$Fstat;
$output["MSd"] = $MSd;
$output["MSe"] = $MSe;
$output["F"] = $Fstat;


$ans = file_get_contents("http://sahildur.pythonanywhere.com/adhoc_ftest/?val=".$Fstat."&degree1=".$num."&degree2=".$deno);

$retrived_p_value=json_decode($ans);

$output["p"]=$retrived_p_value->pval;


$output['names']=$names;


echo json_encode($output);


function computeSSe($name, $mean){
    global $link, $SSe, $output;
    $query = 'SELECT mf.exp 
FROM testtable4 AS tt4
INNER JOIN testtable3 AS tt3 ON tt4.p_id = tt3.p_id
INNER JOIN microarray_fact AS mf ON tt3.s_id = mf.s_id
INNER JOIN probe ON mf.pb_id = probe.pb_id
INNER JOIN testtable5 AS tt5 ON probe.UID = tt5.UID
WHERE tt5.go_id = "0007154"
AND tt4.name = "'.$name.'"
';
    //$query = 'SELECT exp FROM fstatdemo WHERE name ="'.$name.'"';
    $result = mysqli_query($link, $query);
    $tempSum = 0;
    
    while($row = mysqli_fetch_assoc($result)){
        //print_r($row);
        $tempSum += pow($row["exp"]-$mean,2);
        
    }
//    echo $tempSum."<br>";
    $SSe += $tempSum;
    $output["query2"] = $query;
}



?>