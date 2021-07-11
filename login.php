
<html>
<a href='logout.php'>User logout</a><br>

<?php  

// Use db.config
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

if((dns_get_record("kean.edu") == $dnsvalue) || $ipaddress=='10.116.10.5' || $IPv4[0] == "10" || $IPv4[0].".".$IPv4[1] == "131.125"  ){

     echo " You are NOT from Kean University!";
    }else{

      echo " You are from Kean University!";
}
}



// // Connection to DB statement 
$con = mysqli_connect($dbhostname, $dbusername, $dbpassword, $dbname)
or die("<br>Cannot connect to DB:$dbhostname on Customers CPS3740 Database \n");


if(isset($_POST["btnSubmit"])){
	if (isset($_POST['username']) && $_POST['password']) {


 // Define Variables
	$username = $_POST['username'];
	$password = $_POST['password'];

	// converts username to lowercase
	$username=strtolower($username);


//Query that reads statement to check whether code is in DB
$sqlquery =  "SELECT login,id,password, city, zipcode, gender, img, name, state, street, DOB FROM CPS3740.Customers WHERE login = '$username' AND password = '$password'";


// Result From the SQL Query & Connection
 $result = mysqli_query($con, $sqlquery);
 

// Returns an array that corresponds to the fetched row 
$row = mysqli_fetch_array($result);


if($result){

if (mysqli_num_rows($result)>0) {

			
				if ($password== $row['password']){

					$ID = $row['id'];
					$name = $row['name'];


					setcookie("ID", $ID, time() +(60*60*24));
	            	setcookie("customer_name", $name, time() +(60*60*24));

	            	techInfo();

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
                      WHERE c.id = m.cid  AND login='$username' ";


                      $result_set = $con->query($MoneyTblQuery);


                      if (mysqli_num_rows($result_set) > 0) {


// The Number of transactions that the user has
   $queryT = "SELECT count(code) as total FROM CPS3740_2021S1.Money_brodavia, CPS3740.Customers c WHERE cid = '$ID' AND login='$username'";
    $resultT=mysqli_query($con,$queryT);
  	$data=mysqli_fetch_array($resultT);
 
    echo "There are " .$data['total']. " transcations for customer " .$row['name'];


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
 WHERE id=cid AND login='$username' AND password= $password ";

 $balanceResult = mysqli_query($con, $sqlbalance);

 $finalBal = 0;

$balanceArray = array();

if($balanceResult) {

while($balancerow = mysqli_fetch_array($balanceResult)) {


    if($balancerow['type']=='W'){

        $balancerow['amount'] = -1 * $balancerow['amount'];

        array_push($balanceArray, $balancerow['amount']);
    }else{

                array_push($balanceArray, $balancerow['amount']);

    }

    }

// If Balance is < 0 then it should be red or Blue
            if(array_sum($balanceArray)<0) {

               $finalBal= array_sum($balanceArray);
               $finalColor = "FF0000";

                echo " Total balance: $  " .  "<b style=\"color: $finalColor\">$finalBal</b>"; // Was SPan 
                                    
            } else{


                 $finalBal= array_sum($balanceArray);
               $finalColor = "0B2265";
                echo " Total balance: $ " .  "<b style=\"color: $finalColor\">$finalBal</bn>";

            }

        }
 				setcookie("balance", $balanceArray, time()+86400*30);


                			 echo "<br><br><TABLE>";
						
							echo "<TR><TD><form action='Add_Transaction.php' method='POST'>";
							echo "<input type='hidden' name='customer_name' value=\"".$name."\">";
							echo "<input type='submit' value='Add transaction'><span></form>";
							echo "<a href='display_transaction.php'>Display and update transaction</a>";
							echo " &nbsp;&nbsp;  <a href='display_stores.php'>Display Stores</a>";
							echo "<TR><TD colspan=2><form action='search.php' method='get'>";
							echo "Keyword: <input type='text' name='SearchWord'  required='required' >";
							echo "<input type='submit' value='Search transaction'></form>";
							echo "</TABLE></HTML>";
 
echo "</TABLE>";

echo "</body>";

echo "</html>";


} else {
			$Loginquery = "SELECT login FROM CPS3740.Customers WHERE login = '$username'";
			$resultlogin = mysqli_query($con,$Loginquery);
            $row = mysqli_fetch_array($resultlogin);
			

		if ($username == $row['login']) {
	    		echo "<br>Login " . $username . " exists, but password not match.\n";
	    		mysqli_free_result($resultlogin);
	    	
	    	} elseif ($username != $row['login']) {
				echo "<br>Login " . $username ." doesn’t exist in the database.\n";
				mysqli_free_result($resultlogin);
			}
		}
}


}

}
mysqli_close($con);




?>