<?php

include "dbconfig.php";
// If button Submited


if (isset($_POST['submitBTN'])) {
// Checks if Cookie was set
if(isset($_COOKIE['ID'])) {
// Connection Statement 
$con= mysqli_connect($dbhostname, $dbusername, $dbpassword, $dbname)
 or die("<br>Cannot connect to DB:$dbhostname on Money_brodavia CPS3740 Database \n");

	echo  "<a href='logout.php'>User logout</a><br>";
// Declare Cookie variables 
$customer_id = $_COOKIE['ID'];
$note = $_POST['note'];
$Balance = $_COOKIE['balance'];
$name  = $_COOKIE['customer_name'];
// DECLARE Loop Variables 
   
    $i = 0; 
    $row_delete = 0; // x
    $row_update = 0; //z

// SQL statements 
$sqlquery= "SELECT * FROM  CPS3740_2021S1.Money_brodavia WHERE cid= '$customer_id'";

// SQL Result
$result=mysqli_query($con,$sqlquery);
  
// SQL Row 
$row = mysqli_fetch_array($result);

$code = $row["code"];

// Original Note
$oNote = $row['note'];

while($row=mysqli_fetch_array($result)) {

if(!empty($_POST["delete"][$row_delete])) { 

      $delete[$i] = $_POST["delete"][$row_delete];
      $query ="DELETE FROM CPS3740_2021S1.Money_brodavia WHERE mid ='$delete[$row_delete]'";
      $result=mysqli_query($con,$query);     
      // Take codes cookie
      echo "The Code " . $code[$i] ." has been deleted from the database.” ";
      --$row_delete;
      ++$row_update;

}else{
   $note[$i] = $_POST["note"][$row_delete]; 
    $mid[$i] = $_POST["mid"][$row_delete];
  echo "No Record was deleted. Unsuccessfuly Deleted Row!"; 
}
++$i;
++ $row_delete;
}
}
}

else {
    echo "<br> Try again! Cookie NOT SET! REFRESH PAGE OR GO BACK TO HOME PAGE. LINK BELOW!";
    echo "Please click <a href='index.html'>here (project home page)</a> to login again.<br><br>";

   }

mysqli_close($con);


?>






