
<html>
<a href='logout.php'>User logout</a><br>

<?php  

// Use db. config
include "dbconfig.php";

// Default Time Zone Set
date_default_timezone_set('America/New_York');

// Function Concacts User Address
function homeAddress($street, $city, $zipcode) {

    echo "<br>Address: " . $street .", " .$city.", " .$zipcode;
}

// This function calculates the age of the Customer
function calculateAge($dob) {

// Set Variable for Current Date
$currentDate = date("Y-m-d");
// The Difference between User's Date of Birth and current Date 
$difference = date_diff(date_create($dob), date_create($currentDate));
echo "<br> Age: ".$difference -> format('%y');
}


// Display Tech info of the User, such as OS, IP Address, and whether they are from Kean 
function techInfo(){
    echo "<br>";
    // Displays IP Address
    echo ' Your IP: '. $_SERVER['REMOTE_ADDR'] . "\n\n";
    echo "<br>";
    // Displays Browser and OS information 
    echo ' Your browser and OS: ' . $_SERVER['HTTP_USER_AGENT'] . "\n\n";
    echo "<br>";
    // Displays Whether User is from Kean University or not
     $ipaddress = $_SERVER['REMOTE_ADDR'];

$dnsvalue = true;

if(dns_get_record("kean.edu") == $dnsvalue){

     echo " You are NOT from Kean University!";
    }else{

      echo " You are from Kean University!";
}
   /* 

   Hard-Coded Kean IP Address

   if($ipaddress!='10.116.10.5'){

        // echo " You are NOT from Kean University!";
     // }else{

        //  echo " You are from Kean University!";
    //  }
*/

}

// Connection to DB statement 
$con = mysqli_connect($dbhostname, $dbusername, $dbpassword, $dbname)
or die("<br>Cannot connect to DB:$dbhostname on Customers CPS3730 Database \n");

// If the submit button is selected
if(isset($_POST["btnSubmit"])) { // this used to be !isset revert back if problem arises

  // Define Variables
 $username = $_POST["username"]; // Username variable: Use to be GET

 $password = $_POST["password"]; // Password variable: Use to be GET


// converts username to lowercase
$username=strtolower($username);

//Query that reads statement to check whether code is in DB
 $query = "SELECT login,password, city, zipcode, gender, img, name, state, street, DOB FROM CPS3740.Customers WHERE login= '$username' OR password= '$password'";

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

                            setcookie("user",$username,time()+10*60); // Must use Session Key and Cookie OR DO we use something else?
                            // Whenever I refresh I lose data

                            echo "<br>";
                            // Displays Welcome Message to User
                            echo "Welcome Customer: "; 
                            echo "<b>".$row['name'] ."</b>";

                            //Display User Age 
                            $birthDate = $row['DOB'];
                            calculateAge($birthDate);
                            
                            // Displays User Address
                            $userStreet = $row['street'];
                            $userCity = $row['city'];
                            $userZipCode = $row['zipcode'];
                            homeAddress($userStreet, $userCity, $userZipCode);

                            echo "<br>";

                            // Display User Image 
                            echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"/>';


                            // Line Border
                           echo '<hr/>'; 
                           

                        // Display all records for the logged in customer in your Money_xxxx table that you created and and inserted in Homework1.
                      $MoneyTblQuery = "SELECT mid, code, cid, type, amount, mydatetime, note 
                      FROM CPS3740_2021S1.Money_brodavia m inner join CPS3740.Customers c
                      WHERE c.id = m.cid  AND login='$username' "; // Link it to users login and name 


                        $result_set = $con->query($MoneyTblQuery);


// Prints Table for Customer 
if (mysqli_num_rows($result_set) > 0) {


// The Number of transactions that the user has
    echo "<hr>There are" . " transcations for customer " .$row['name'];


// output data of each row
echo "<TABLE width='1000'>";  // open the table and start tag
echo "<TABLE border=1>\n
<tr>    
<th>ID</th>
<th>Code</th>
<th>Type</th>
<th>Amount</th>
<th>Source</th>
<th>Date Time</th>
<th>Note</th>
</tr> ";

if($result_set){
  
        while($row = mysqli_fetch_array($result_set)) {

    $ID= $row["mid"];
    $code = $row["code"];
    $type =$row["type"];
    $amount=$row["amount"];
    $mydatetime = $row["mydatetime"];
    $note = $row["note"];

    if($row['type'] == 'W'){

       $tdStyle = 'red';

        } elseif($row['type'] == 'D'){
    $tdStyle = 'blue';
}
echo "<tr><td>" . $ID. "</td><td>" . $code . "</td><td>" . $type. " <td style= color:{$tdStyle};'>{$row['amount']}</td>"."</td><td>". "</td><td>" 

. $mydatetime. "</td><td>" . $note. "</td></tr>";

                        }

            } 

                echo "</TABLE>\n";
    }

 }
    
// Develop out Calculate and display the balance under the table. If the balance < 0, please highlight in RED.
// Otherwise, display the amount in BLUE color.

$sqlbalance = "SELECT amount, type
 FROM CPS3740_2021S1.Money_brodavia m inner join CPS3740.Customers c
 WHERE id=cid AND login='$username'";

 $balanceResult = mysqli_query($con, $sqlbalance);

 $finalBal = 0;

$balancearray = array();

if($balanceResult) {

while($balancerow = mysqli_fetch_array($balanceResult)) {


    if($balancerow['type']=='W'){

        $balancerow['amount'] = -1 * $balancerow['amount'];

        array_push($balancearray, $balancerow['amount']);
    }else{

                array_push($balancearray, $balancerow['amount']);

    }

    }

   echo "Total balance: " . array_sum($balancearray);

// If Balance is < 0 then it should be red 



 // On the customer home page, add additional 4 functions - “Search transaction” a HTML form with a
//textbox and a button, “Add transaction” a HTML form with a button, “Display and update transaction” – a link .
// “Display stores” – a link.>
echo "<form action='add_transaction.php' method='POST'>";

   echo "  <input type='hidden' name='customer_name' value= 'customer_name' > <! Change customer name probably later in the future>";

    echo "  <input type='submit' value='Add Transaction'><span></form> ";

  echo " <a href='display_transaction.php'>Display and Update transactions</a>";

    echo " &nbsp;&nbsp;  <a href='display_stores.php'>Display Stores</a>";

     echo "<form action='search.php' method='get'><br>";

    echo " Keyword: <input type='text' name='keyword' required='required'>";

     echo "<input type='submit' value='Search Transaction'></form>";






}


 }
                //  If the Login is not in Database 
            else { 
                    echo "Login ".$username." doesn’t exist in the database";

                        }

                    }
        }

mysqli_close($con);

?>





</html>






