<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "amongbus";
$dbconnect = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$dbconnect) {
    die("Something went wrong;");
}


function loginsuccess($user_id)
		{
			echo "<script>
			alert('Login Successful')
					location.href = 'index.php?id=$user_id';
					</script>";
		}

?>