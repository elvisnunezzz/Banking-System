<?php
        include "dbconfig.php";


	
	 


        $query = "select avg(latitude) as averaLatitude, avg(longitude) as averaLongitude from CPS3740.Stores where city is not null and address is not null and latitude is not null and longitude is not null";
        $result=mysqli_query($link, $query);

        if(!$result)
            echo mysqli_error($link);

        while($row=mysqli_fetch_array($result)){
            $averaLatitude=$row['averaLatitude'];
            $averaLongitude=$row['averaLongitude'];
        }



        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script type="text/javascript">    
        var i=0;

        function initialize() {
            var mapOptions = {
                zoom: 4,

                center: new google.maps.LatLng(<?php echo $averaLatitude; ?>, <?php echo $averaLongitude ?>),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

            var infowindow = new google.maps.InfoWindow();

            var markerIcon = {
                scaledSize: new google.maps.Size(80, 80),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(32,65),
                labelOrigin: new google.maps.Point(40,33)
            };
            var location;
            var mySymbol;
            var marker, m;
            var MarkerLocations= [ <?php

                $query = "select * from CPS3740.Stores where city is not null and address is not null and latitude is not null and longitude is not null; ";
                $result=mysqli_query($link,$query);


                $rowcount= mysqli_num_rows($result);

                $i=1;

                while($row=mysqli_fetch_array($result)){
                    $sid=$row['sid'];
                    $name=$row['Name'];
                    $lat=$row['latitude'];
                    $long=$row['longitude'];
                    $addres=$row['address'];
                    $city=$row['city'];
                    $state=$row['State'];
                    $zipcode=$row['Zipcode'];
                    $dir = $addres.", ".$city.", ".$state." ".$zipcode;


                    if ($i != $rowcount){
                        echo "['$sid', '$name', $lat , $long, '$dir' ] ,";
                        $i++;
                    }
                    else{
                        echo "['$sid', '$name', $lat , $long, '$dir' ] ";

                    }
                } ?>
            ];

            for (m = 0; m < MarkerLocations.length; m++) {

                location = new google.maps.LatLng(MarkerLocations[m][2], MarkerLocations[m][3]),
                    marker = new google.maps.Marker({
                        map: map,
                        position: location,
                        icon: markerIcon,
                        label: {
                            text: MarkerLocations[m][0] ,
                            color: "black",
                            fontSize: "16px",
                            fontWeight: "bold"
                        }
                    });

                google.maps.event.addListener(marker, 'click', (function(marker, m) {
                    return function() {
                    	console.log(MarkerLocations[m]);
                        infowindow.setContent("Store ID : " + MarkerLocations[m][1] + "<br>"+MarkerLocations[m][4]);                       
                        infowindow.open(map, marker);
                    }
                })(marker, m));
            }
        }
        google.maps.event.addDomListener(window, 'load', initialize);;








    </script>

</head>
<body>
<div style="margin:auto;  width: 720px; ">
<strong style="position: absolute">The following stores are in the database.</strong><br>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Address</th>
        <th>City</th>
        <th>State</th>
        <th>Zipcode</th>
        <th>Location (Latitude,Longitude) </th>


    </tr>
    <?php

   include "dbconfig.php";


    

    $query = "select sid, Name,address,city,State,Zipcode,concat(latitude,', ',longitude) as coordinates from CPS3740.Stores where city is not null and address is not null and latitude is not null and longitude is not null";
    $result = mysqli_query($link,$query);
    if(!$result)
        echo mysqli_error($link);
    while($row = mysqli_fetch_array($result)) {

        echo "<tr>
                    <td>" . $row["sid"] . "</td>
                    <td>" . $row['Name'] . "</td>
                    <td>" . $row['address'] . "</td>
                    <td>" . $row["city"] . "</td>             
                    <td>" . $row["State"] . "</td>
                    <td>" . $row["Zipcode"] . "</td>     
                    <td>".$row["coordinates"]."</td>     


                </tr>";
    }
    ?>
</table>

<div id="map-canvas" style="height: 400px; width: 720px;"></div>
</div>
</body>
</html>