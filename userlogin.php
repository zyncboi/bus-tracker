<?php
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
	<title>Login - AmongBus</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</head>


<body style="background-color: #C3CC69">
	<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; ">
		<?php
		include 'connect.php';

		if (isset($_POST['email']) && isset($_POST['password'])) {
		    $email = $_POST['email'];
		    $password = $_POST['password'];
		    $type = $_POST['type'];
		    
		    if (empty($email)) {
		        header("Location: userlogin.php?error=Please Input Email Address");
		        exit();
		    } elseif (empty($password)) {
		        header("Location: userlogin.php?error=Password is Required");
		        exit();
		    } else {

		        $query = mysqli_query($dbconnect, "SELECT * FROM $type WHERE Email = '$email'") or die("Failed ->" . mysql_error());
		        $user = mysqli_fetch_array($query, MYSQLI_ASSOC);

		        if ($user) {
		            $hashedPassword = $user['Password'];
		            $user_id = $user['user_id'];
		            
		            
		            if (password_verify($password, $hashedPassword)) {
		                session_start();
		                $_SESSION['user'] = 'yes';
		                $_SESSION['user_id'] = $user_id;
		                $_SESSION['firstname'] = explode(" ", $user['First'])[0];
		                $_SESSION['user_id'] = $user_id;
		                header("Location: ..");
		                if ($type == 'DRIVERS') {
		                	 $_SESSION['driver_id'] = $user['driver_id'];
		                	 $_SESSION['capacity'] = $user['capacity'];
		                	 header("Location: ../driver/");
		                }
		                exit();
		            } else {
		                header("Location: userlogin.php?error=Incorrect Password&hp=".$hashedPassword."&email=".$email);
		                exit();
		            }
		        } else {
		            header("Location: userlogin.php?error=Incorrect Login");
		            exit();
		        }
		    }
		}
		?>
		<form class="p-5 rounded shadow" action="userlogin.php" method="POST" style="background-color: #F4FF84">
			<h1 class="text-center pb-5 display-4" style="width: 30rem;"> LOGIN </h1>
			<?php if ($_GET['error']) { ?>
				<div class="alert alert-danger" role="alert"><?php echo $_GET['error']; ?></div>
			<?php } ?>
			<div class="mb-3">
			  <label for="exampleInputEmail1" class="form-label">Email address</label>
			  <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email Address" required>
			</div>

			<div class="mb-3">
			  <label for="exampleInputPassword1" class="form-label">Password</label>
			  <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"required>
			</div>

			<div class="mb-3">
				<input class="form-check-input" type="radio" name="type" id="flexRadioDefault1" value="STUDENT" checked required>
			      <label class="form-check-label" for="flexRadioDefault1">
			        Commuter
			      </label>
			      <input class="form-check-input" type="radio" name="type" id="flexRadioDefault2" value="DRIVERS">
			      <label class="form-check-label" for="flexRadioDefault2">
			        Driver
			      </label>
			</div>

			<button class="btn btn-secondary" type="submit">Login</button> <span> New User? <a href="../register/"> Register Now.</a></span>
		</form>
	</div>
</body>
</html>