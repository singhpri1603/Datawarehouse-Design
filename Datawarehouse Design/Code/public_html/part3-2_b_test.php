<?php
include("dbconn.php");

$ans = file_get_contents("http://sahildur.pythonanywhere.com/adhoc_test/?val=3.120&degree=8");
echo $ans
?>