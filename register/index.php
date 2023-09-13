<?php
error_reporting(E_ALL);
	session_start();
    if (isset($_SESSION['user_id'])) {
    	header("location: ..");
    }	
    elseif (isset($_SESSION['driver_id'])) {
    	header("location: ../driver/");
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register - AmongBus</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</head>


<body style="background-color: #C3CC69">
	<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; ">
		<?php
		include '../connect.php';
		

		if (isset($_POST['email']) && isset($_POST['first']) && isset($_POST['type']) && isset($_POST['last']) && $_POST['password'] == $_POST['password2']) {
		    $email = $_POST['email'];
		    $password = $_POST['password'];
		    $first = $_POST['first'];
		    $last = $_POST['last'];
		    $type = $_POST['type'];
		    $route = $_POST['route'];
		    $plate = $_POST['plate'];
		    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
		    #print("$email <br> $password <br> $first <br> $last <br> $type <br> $route <br> $plate <br> $hashedPassword <br>");
		   	if ($_POST['password'] != $_POST['password2']) {
				header("Location: ../register/?error=Password must match.");
			}else{
				if ($type == 'DRIVERS') {
					
					$query = mysqli_query($dbconnect, "INSERT INTO `$type`(`FirstName`, `LastName`, `Route`, `Plate`,`Email`, `Password`) VALUES ('$first','$last','$route','$plate','$email','$hashedPassword')");
					
					if ($query) {
						$query = mysqli_query($dbconnect, "SELECT * FROM $type WHERE Email = '$email'") or die("Failed ->" . mysql_error());
		       			$user = mysqli_fetch_array($query, MYSQLI_ASSOC);
		       			$_SESSION['driver_id'] = $user['driver_id'];
		       			header("Location: ../driver/");
					}else{
						header("Location: ../register/?error=Error Occured.");
					}
				}
				elseif ($type == 'STUDENT') {
					
					$query = mysqli_query($dbconnect, "INSERT INTO `$type`(`First`, `Last`,`Email`, `Password`) VALUES ('$first','$last','$email','$hashedPassword')");
					
					if ($query) {
						$query = mysqli_query($dbconnect, "SELECT * FROM $type WHERE Email = '$email'") or die("Failed ->" . mysql_error());
		       			$user = mysqli_fetch_array($query, MYSQLI_ASSOC);
		       			$_SESSION['firstname'] = explode(" ", $user['First'])[0];
		       			$_SESSION['user_id'] = $user['user_id'];
		       			header("Location: ..");
					}else{
						header("Location: ../register/?error=Error Occured.");
					}
				}
			}
		}
		?>
		<form class="p-5 rounded shadow" action="../register/index.php" method="POST" style="background-color: #F4FF84">
			<h1 class="text-center pb-5 display-4" style="width: 30rem;"> Register </h1>
			<?php if ($_GET['error']) { ?>
				<div class="alert alert-danger" role="alert"><?php echo $_GET['error']; ?></div>
			<?php } ?>

			<div class="mb-3">
			  <label for="registerinputemail" class="form-label">Email address</label>
			  <input name="email" type="email" class="form-control" id="registerinputemail" placeholder="Email Address"required>
			</div>

			<div class="row g-3">
			  <div class="col">
			    <input type="text" name="first" class="form-control" placeholder="First name" aria-label="First name"required>
			  </div>

			  <div class="col">
			    <input type="text" name="last" class="form-control" placeholder="Last name" aria-label="Last name"required>
			  </div>
			</div>

			<div class="mb-3">
			  <label for="exampleInputPassword1" class="form-label">Password</label>
			  <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"required>
			  <label for="exampleInputPassword2" class="form-label">Repeat Password</label>
			  <input name="password2" type="password" class="form-control" id="exampleInputPassword2" placeholder="Password"required>
			</div>

			<div class="mb-3">
				<input class="form-check-input" type="radio" name="type" id="flexRadioDefault1" value="STUDENT" onclick="hide()" required>
			      <label class="form-check-label" for="flexRadioDefault1">
			        Commuter
			      </label>
			      <input class="form-check-input" type="radio" name="type" id="flexRadioDefault2" value="DRIVERS" onclick="hideShow()">
			      <label class="form-check-label" for="flexRadioDefault2">
			        Driver
			      </label>
			</div>

			<div id="driveronly" class="mb-3" style="display: none;">
			  <label for="exampleInputPassword1" class="form-label">Route</label>
			  <input name="route" type="text" class="form-control" id="route" placeholder="Route">
			  <label for="exampleInputPassword2" class="form-label">Plate Number</label>
			  <input name="plate" type="text" class="form-control" id="plate" placeholder="Plate Number">
			</div>


			<button class="btn btn-secondary" type="submit">Register</button> <span> Already registerd? <a href="../userlogin.php"> Login.</a></span>
		</form>
	</div>


</body>


<script type="text/javascript">
	var div = document.getElementById('driveronly');
	var display = 0;
	function hideShow(){
		if (display == 1) 
		{
			div.style.display = 'none';
			display = 0;
		}
		else{
			div.style.display = 'block';
			display = 1;
		}
	}

	function hide(){
			div.style.display = 'none';
			display = 0;
	}
</script>
</html>