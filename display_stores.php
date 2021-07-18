<?php

include 'dbconfig.php';

$con = mysqli_connect($dbhostname, $dbusername, $dbpassword, $dbname)
 or die("<br>Cannot connect to DB:$dbhostname on Stores CPS3740 Database \n");


$sqlquery = "SELECT *
        FROM CPS3740.Stores
        WHERE city is not null 
        and address is not null 
        and latitude is not null 
        and longitude is not null";

$result = mysqli_query($con, $sqlquery);

if ($result) {
    echo "The Following Stores That Are In The database: ";
    if (mysqli_num_rows($result) > 0) {


echo "<TABLE width='1000'>";  // open the table and start tag

        echo "<br><table border='1'>";
        echo "<tr><th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zipcode</th>
            <th>Location(Latitude, Longitude)</th>
            </tr>";

        while($rows = mysqli_fetch_array($result)) {
            $id = $rows['sid'];
            $name = $rows['Name'];
            $address = $rows['address'];
            $city = $rows['city'];
            $state = $rows['State'];
            $zip = $rows['Zipcode'];
            $lat = $rows['latitude'];
            $log = $rows['longitude'];

            echo "<tr>
                <td>$id</td>
                <td>$name</td>
                <td>$address</td>
                <td>$city</td>
                <td>$state</td>
                <td>$zip</td>
                <td>($lat,$log)</td>
                </tr>";
        }
    }
  
}

?>