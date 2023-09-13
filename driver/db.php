<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "amongbus";
$dbconnect = mysqli_connect($servername, $username, $password, $dbname);
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$id = $_POST['id'];
$capacity= $_POST['capacity'];

$sql = "UPDATE DRIVERS SET capacity='$capacity' WHERE driver_id = '$id'";

if ($conn->query($sql) === TRUE) {
	$query = mysqli_query($dbconnect, "SELECT * FROM DRIVERS WHERE driver_id = '$id'") or die("Failed ->" . mysql_error());
	$user = mysqli_fetch_array($query, MYSQLI_ASSOC);
	$capacity = $user['Capacity'];
    echo $capacity;

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>