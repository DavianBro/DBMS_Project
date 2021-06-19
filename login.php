<?php  

// Use db. config
include "dbconfig.php";


// Display Tech info of the User, such as OS, IP Address, and whether they are from Kean 
function techInfo(){
    echo "<br>";
    // Displays IP Address
    echo ' Your IP: '. $_SERVER['REMOTE_ADDR'] . "\n\n";
    echo "<br>";
    // Displays Browser and OS information 
    echo ' Your browser and OS: ' . $_SERVER['HTTP_USER_AGENT'] . "\n\n";
    // Displays Whether User is from Kean University or not 
    echo "<br>";
    


// Put in HTML




}

// Successful Login Function 




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

                            techInfo();


                            // Build out fnction 


                }
            }
            // If the Login is not in Database 
            else { 
                    // Not my code chop up 
                    echo "Login ".$username." doesn’t exist in the database";

                        }

                    }
        }






       


mysqli_close($con);

?>