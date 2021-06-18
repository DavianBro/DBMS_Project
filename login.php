<?php  
// 1.2 _____ (5 pts) If the login does not exist in the database, please display an error message “Login XXXX doesn’t
// exist in the database” and exit the program.
// 1.4 _____ (5 pts) All other main items should be available only when the login and password match the record in the
// database which is considered login successfully.

// Use db. config
include "dbconfig.php";

// Connection to DB statement 
$con = mysqli_connect($dbhostname, $dbusername, $dbpassword, $dbname)
or die("<br>Cannot connect to DB:$dbhostname on Customers CPS3730 Database \n");

// If the submit button is selected
if(!isset($_POST['submitbutton'])) {

  // Define Variables
 $username = $_POST["username"]; // Username variable: Use to be GET

 $password = $_POST["password"]; // Password variable: Use to be GET

// converts username to lowercase
$username=strtolower($username);

//Query that reads statement to check whether code is in DB
 $query = "SELECT login,password FROM CPS3740.Customers WHERE login= '$username' OR password= '$password'";

 // Result From the SQL Query & Connection
$result = mysqli_query($con, $query);

// Boolean Statement if $result has value
if($result) {

    if (mysqli_num_rows($result) > 0) {

            // Returns an array that corresponds to the fetched row 
          $row = mysqli_fetch_array($result);

                    //if wrong password then
                   if($row['password']!=$password) {

                echo "Login ".$row['login']." exists, but password does not match.";

                     }
                        // If Login is Successful 
                        else { 

                    echo "Login : ".$username." and Password : ".$password." are present.Login successfull";
                    // Build Out The Rest Of The Module through this and get rid of it 

                }
            }
            // If the Login is not in Database 
            else { //if login is not present


// Not my code chop up 
echo "Login ".$username." doesn’t exist in the database";

}

}



        }


mysqli_close($con);

?>