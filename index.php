<?php 

    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location:userlogin.php");
    }
    elseif (isset($_SESSION['driver_id'])) {
        header("location: ../driver/");
    }
     $user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home - AmongBus</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.16.4"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- LEAFLET JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

</head>

<body style="text-align: center; background-color: #F0F8FF">

    <!-- Navigation -->
    <nav class="navbar navbar-light navbar-expand-md bg-info justify-content-between">


        <div class="container-fluid">
            <h2 class="navbar-text justify-content-center" style='font-family: "Lucida Console", "Courier New", monospace;'>AmongBus</h2>
        </div>
    </nav>




    <nav class="">
        <p style="font-family:Lucida Console; margin-top: 20px"> Welcome to AmongBus,
            <?php echo $_SESSION['firstname']; ?> !
            <p>
    </nav>


    <div id="map" style="width:60%; height: 40vh; margin: auto"></div>

    <footer>
        <br>
        <a href="../logout.php">Logout</a>
    </footer>
</body>


<style>
    * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
        box-sizing: border-box;
    }
    
    body {
        height: 100vh;
        /*display: flex;*/
        /*justify-content: center;*/
        text-align: center;
        background-color: #F0F8FF;
    }
    
    h1 {
        position: absolute;
        top: 30%;
        font-size: 60px;
        color: white;
    }
    
    .box {
        width: 500px;
        height: 50px;
        background-color: white;
        border-radius: 30px;
        display: flex;
        align-items: center;
        padding: 20px;
    }
    
    .box>i {
        font-size: 20px;
        color: #777;
    }
    
    .box>input {
        flex: 1;
        height: 40px;
        border: none;
        outline: none;
        font-size: 18px;
        padding-left: 10px;
    }
    
    #map {
        justify-content: center;
        height: 180px;
        width: 50%;
    }
</style>



</html>
<!-- leaflet js  -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([10.338304, 123.9220224], 20);
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });
    osm.addTo(map);

    if(!navigator.geolocation) {
        console.log("Your browser doesn't support geolocation feature!")
    } else {
        setInterval(() => {
            navigator.geolocation.getCurrentPosition(getPosition)
        }, 5000);
    }

    var marker, circle;

    function getPosition(position){
        // console.log(position)
        var lat = position.coords.latitude
        var long = position.coords.longitude
        var accuracy = position.coords.accuracy

        if(marker) {
            map.removeLayer(marker)
        }

        if(circle) {
            map.removeLayer(circle)
        }

        marker = L.marker([lat, long])
        circle = L.circle([lat, long], {radius: accuracy})

        var featureGroup = L.featureGroup([marker, circle]).addTo(map)

        map.fitBounds(featureGroup.getBounds())

        console.log("Your coordinate is: Lat: "+ lat +" Long: "+ long+ " Accuracy: "+ accuracy)
    }

</script>