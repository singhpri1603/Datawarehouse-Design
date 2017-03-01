<?php
include("dbconn.php");
include("views/header.php");

if(isset($_GET["page"])){
   if($_GET["page"] == "part2"){
       include("views/part2.php");
       
    }if($_GET["page"] == "view3"){
       include("views/view3.php");
       
    } 
}

    include("views/home.php");


include("views/footer.php");

?>