
<?php

echo "hello php";

$servername = "79.170.40.235";
$username = "cl22-cse601";
$password = "N-.HRmJ-x";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";


//$query=mysql_query("select * from 'testtable'");
$sql = "CREATE TABLE MyGuests (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP
)";
$result = $conn->query($sql);
echo $result;
echo "Connected successfully2";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row;
    }
} else {
    echo "0 results";
}
$conn->close();
?>
<h1>Default Index Page</h1>

<p>This is the default index.html page for your hosting package. You can edit or delete it in the file manager in your control panel.</p>

