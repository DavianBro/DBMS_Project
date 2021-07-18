
<?php


// echo "<a href = 'logout.html'>User Logout</a>";
echo "<a href = 'logout.php'>User Logout</a>";

echo "<br><br>";
echo "<h1>Add Transaction</h1>";

include "dbconfig.php";


$con = mysqli_connect($dbhostname, $dbusername, $dbpassword, $dbname)
 or die("<br>Cannot connect to DB:$dbhostname on Customers CPS3740 Database \n");

//  Your program should retrieve all the source id and names first from CPS3740.Sources table, and
// only display the source names in the dropdown list for the customer to select, but you need to pass the source id to the next program insert_transaction.php. Note: Do NOT // hardcode the Source values, they will be changed.

$query = "SELECT * FROM CPS3740.Sources";

$result = mysqli_query($con, $query);

// If Cookie is set
if(isset($_COOKIE['ID'])) {

// Declare Cookie Variable 
$name=$_COOKIE['customer_name'];
$id =  $_COOKIE['ID'];
$bal = $_COOKIE['balance'];


// Welcome statement to user
echo "Welcome Back <b>".$name."!</b>";

// HTML Variable for Color Blue
        $vBlue = "\"blue\"";
         // HTML Variable for Color Red
        $vRed = "\"red\"";

if ($bal > 0){
    echo " Current Balance: $ <font color = '$vBlue'><b>$bal</font></b>";
}
elseif ($bal <= 0){
    echo " Current Balance: $ <font color = '$vRed'><b>$bal</font></b>";
}

echo "<form action='insert_transaction.php' method='POST'>";

echo '<br>Transaction Code: 
        <input type = "text" name="code" required="required"
            placeholder="Enter transaction ID(required)"> ';

echo '<input type="radio" name="type" required="required"  value="D">Deposit 
        <input type="radio" name="type" required="required"  value="W">Withdraw';

echo '<br>Amount:
        <input type="text" name="amount" required="required"
            placeholder="Enter amount here(required)">';

echo "<br>Select a Source:";
echo '<select name="source">';

// Pulls from CPS 3740 Sources for list.
    while($row = mysqli_fetch_array($result)) {

     $sname = $row['name'];
      $sid = $row['id'];
     echo "<option value='$sid'>$sname</option>";
    }
echo '</select>';

echo '<br>Note:
    <input type="text" name="note" required="required" placeholder="Enter Note(if any)">';

echo '<br><br><input type="submit" name="submit" value="Submit">';

echo "</form>";

// If Cookie Not set 
}else{

echo " Cookie Not Set. Please Login First ";
 echo "Please click <a href='index.html'>here (project home page)</a> to login again.<br><br>";

}

?>
</html>







