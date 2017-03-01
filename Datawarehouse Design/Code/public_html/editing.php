<?php
$servername = "79.170.40.235";
$username = "cl22-cse601";
$password = "N-.HRmJ-x";

$link = mysqli_connect($servername, $username, $password, $username);

if(mysqli_connect_errno()){
    echo "Unable to connect";
    exit();
    
} echo "Connection success <br>";

$query = "SHOW COLUMNS FROM `testtable2`;";

$result = mysqli_query($link, $query);
while($row=mysqli_fetch_assoc($result)){
    echo $row['Field'];
    echo "<br>";
    $query = "UPDATE `testtable2` SET `".$row['Field']."`='akshay' WHERE `".$row['Field']."`='khiladi';";
    echo $query;
    echo "<br>";
    mysqli_query($link, $query);
    //UPDATE `testtable2` SET `testname`="akshay" WHERE `testname`="khiladi";
}

?>