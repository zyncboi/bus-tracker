<?php session_start(); if (!isset($_SESSION['driver_id'])) {
    header("Location: ..");
}
$driver_id = $_SESSION['driver_id'];
include '../connect.php';
 $query = mysqli_query($dbconnect, "SELECT * FROM DRIVERS WHERE driver_id = '$driver_id'") or die("Failed ->" . mysql_error());
$user = mysqli_fetch_array($query, MYSQLI_ASSOC);
$capacity = $user['Capacity'];
?>

<html>

<head>
    <title>AmongBus Driver</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="drivers-wrapper">
        <span>
            <h1 style="text-align: center"> Capacity:  <?php echo $capacity ?> </h1> 
            
        </span>
    </div>
    <div class="btns-center">
        <button class="btn-wrapper btn-available" onclick="updateCapacity('AVAILABLE')" value="AVAILABLE">Seats Available</button>
        <button class="btn-wrapper btn-standing" onclick="updateCapacity('STANDING')" value="STANDING">No Seats/Standing Only</button>
        <button class="btn-wrapper btn-full" onclick="updateCapacity('FULL')" value="FULL">No Seats/Standing</button>
    </div>

    <footer>
      <p style="text-align: center"><a  href="../logout.php">Logout.</a></p>
    </footer>
</body>


<script>
    function updateCapacity($capacity) {

        console.log($capacity);
        let $driver_id = <?php echo $driver_id; ?>;
        $.ajax({
            url: "db.php",
            data: {
                id: $driver_id ,
                capacity: $capacity
            },
            type: "POST",
            success: function(data) {
                
                console.log("Updated Capacity to " + $capacity);
                $("#capacityupdate").append(data);
                window.location.reload();

            },
            error: function() {
                alert("Error Occured While Updating Capacity");
            }
        });
    }

    function clearupdate() {
    var x = document.getElementsByClassName("capacityupdate");
    for(var i=0; i < x.length; i++){
        x[i].remove();
    }
    var parent = document.getElementById("capacityupdate");

    }
</script>

</html>