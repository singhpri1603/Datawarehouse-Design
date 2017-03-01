<?php
include("dbconn.php");
function tableGen($row){
    $output = '<tr>';
    foreach($row as $key => $value){
        $output.='<td>'.$value.'</td>';
    }
    $output .= '</tr>';
    
    return $output;
}
function headerGen($row){
    $output = '<table class="table table-striped table-sm"><thead><tr>';
    foreach(array_keys($row) as $key){
        $output.='<th>'.$key.'</th>';    
    }
    $output.='</tr></thead><tbody>';
    return $output;
}
if ($_GET['action'] == "customQuery"){
    global $link;
    $query = $_POST["query"];
    if(!$result = mysqli_query($link, $query)){
        echo mysqli_error($link);
        exit();
    }
    echo mysqli_num_rows($result)." results";
    $output = '';
    if($row = mysqli_fetch_assoc($result)){
        $output .= headerGen($row);
        $output.=tableGen($row);
    }
    
    //print_r($list);
    
    while($row = mysqli_fetch_assoc($result)){
        $output .= tableGen($row);
    }
    $output.='</tbody></table>';
    echo $output;
}

?>