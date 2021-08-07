<?php

// Include db.configh file
include "dbconfig.php";

$con = mysqli_connect($dbhostname, $dbusername, $dbpassword, $dbname)
 or die("<br>Cannot connect to DB:$dbhostname on Customers CPS3740 Database \n");


// Major issue with displaying wrong amount. 
if(isset($_COOKIE['ID'])) {

 	// Declare Cookie Variables
 	$ID = $_COOKIE['ID']; 
    $transaction_code = $_POST['code'];
    $name = $_COOKIE['customer_name'];

	// 1st SQL Query TO Run FOR DATA FOR TABLE
		$sqlquery =   "Select * FROM CPS3740_2021S1.Money_brodavia  WHERE code = '$transaction_code' and cid = $ID";

// THE RESULT
    $result  = mysqli_query($con,$sqlquery);

//***** REFERENCE*******
// 1 = 1st query
// 2 = 2 sql query
// 3 =3rd sql query

// If Mysqli rows == 0 then set variables and run code
    if (mysqli_num_rows($result) == 0) {
        $type = $_POST['type'];
        $sid = $_POST['source'];
        $amt = $_POST['amount'];
        $note = $_POST['note'];

        // Second SQL Query 
        $sqlquery2 = "SELECT sum(amount) as bal FROM CPS3740_2021S1.Money_brodavia WHERE cid = $ID";

        // Result from second query 
        $result2 = mysqli_query($con, $sqlquery2);

        $row = mysqli_fetch_array($result2);

        $balance = $row['bal'];
        
        // if if is a deposit 
        if ($type == 'D') {

                  // If deposit does not equal 0 
                if($amt != 0 && $amt > 0) {

          
            // Balance + Amount = the new balance 
            $newBal = $balance + $amt;

            $sqlquery3 = "INSERT INTO CPS3740_2021S1.Money_brodavia
                    (code, cid, sid, type, amount, mydatetime, note) VALUES
                    ('$transaction_code', '$ID', '$sid', '$type', '$amt', NOW(), '$note')";
            
            if(mysqli_query($con, $sqlquery3)) {
                echo "<a href='logout.php'>User logout</a><br>"; // user log out 
                echo "THE TRANSACTION $transaction_code WAS SUCCESSFUL! ";
                echo "<br>Your NEW BALANCE is: $$newBal";

            }

}
           
else {
                echo "<a href='logout.php'>User logout</a><br>";
                echo " <font color = red > ERROR! AMOUNT CANNOT BE LESS THAN OR EQUAL TO 0  </font>";
            }

              

    } 


        // If Withdraw 
        else { // ($amt != 0) && ($amt<!0)
            if ($amt > $balance) {
                echo ' <font color = red> ERROR! INSUFFICIENT FUNDS! YOU CAN ONLY WITHDRAW LESS THAN THAN THE ACCOUNT BALANCE</font>';
                // Else if if amount is 0
            } else if (($amt == 0) || ($amt<0)) {

                echo "<a href='logout.php'>User logout</a><br>";
                echo " <font color = red > ERROR! AMOUNT CANNOT BE LESS THAN OR EQUAL TO 0  </font>";

            }
           // 
            else {
                $amt = $amt*(-1);
                $newBal = $balance + $amt;
                $sqlquery4 = "INSERT INTO CPS3740_2021S1.Money_brodavia
                        (code, cid, sid, type, amount, mydatetime, note) VALUES
                        ('$transaction_code', '$ID', '$sid', '$type', '$amt', NOW(), '$note')";

                if (mysqli_query($con, $sqlquery4)) {
                    echo "<a href='logout.php'>User logout</a><br>";
                    echo "TRANSACTION $transaction_code SUCCESSFUL";
                    echo "<br> Your NEW BALANCE is: $$newBal"; // Delete p2
                }
                else {
                    echo "<a href='logout.php'>User logout</a><br>";
                    echo "<font color = red> TRANSACTION NOT SUCCESSFUL! No Data Added to Table </font></p1>";
                }
                

            }

        }

    }
    else {
        echo "<a href='logout.php'>User logout</a><br>";
        echo "<br> <font color = red> ERROR! CODE MUST BE UNIQUE: No Data Added to Table.</font>";
    }

}else{
           if(!isset($_COOKIE)){

                echo "<br>Cookie not set log in again.";

                 echo "Please click <a href='index.html'>here (project home page)</a> to login again.<br><br>";

            }


        
    }

?>
