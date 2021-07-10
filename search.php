

<?php

include "dbconfig.php";

$con = mysqli_connect($dbhostname, $dbusername, $dbpassword, $dbname)
or die("<br>Cannot connect to DB:$dbhostname on Customers CPS3730 Database \n");

$sqlquery = 

$valueToSearch = $_POST['Search Transaction'];

if($valueToSearch=='*') { 




}








?>