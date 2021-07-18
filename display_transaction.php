<?php
include 'dbconfig.php';

$con = mysqli_connect($dbhostname, $dbusername, $dbpassword, $dbname)
 or die("<br>Cannot connect to DB:$dbhostname on Customers CPS3740 Database \n");

// echo "<a href = 'logout.html'>User Logout</a><br><br>";
echo "<a href = 'logout.php'>User Logout</a>";

// You can only update Note column
echo "<br> You can only update the <b>Note</b> Column.";

// Declare Cookie Variables
$name = $_COOKIE['customer_name'];
$cid = $_COOKIE['ID']; 

$query = "SELECT * FROM CPS3740_2021S1.Money_brodavia m, CPS3740.Sources s
        WHERE m.cid = $cid
        AND m.sid = s.id
        order by mydatetime ASC";

$result = mysqli_query($con, $query);

$balance=0;

if($result){

    if(mysqli_num_rows($result) > 0) {  

        $x = 0;  // this used to be a


        echo "<form action = 'update_transaction.php' method ='POST'>";  
        echo "<TABLE width='1000'>";  // open the table and start tag
        echo "<br><TABLE border='1'>";
        echo "<tr><th>ID</th>
            <th>Code</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Source</th>
            <th>Date Time</th>
            <th>Note</th>
            <th>Delete</th>
            </tr>";

            while($row = mysqli_fetch_array($result)) {
            $mid = $row['mid'];
            $code = $row['code'];
            $sid = $row['sid'];
            $type = $row['type'];
            $amount = $row['amount'];
            $balance += $amount;
            $datetime = $row['mydatetime'];
            $note = $row['note'];
            $source = $row['name'];
   

            echo "<tr><td><input type = 'text' value = '$mid' name = 'mid[$x]' readonly = 'true'></input></td>
                <td>$code</td>";

                // Add code for colors 



            if ($type == 'D') {
                echo "<td><font color = \"blue\">$amount</font></td>
                        <td>Deposit</td>";
            }
            else { // If Withdraw
                echo "<td><font color = \"red\">$amount</font></td>
                    <td>Withdraw</td>";
            }


            echo "
                <td>$source</td>
                <td>$datetime</td>
                <td bgcolor='yellow' ><input type='text' style='background-color:yellow;' name='note[$x]' value='$note'></input></td>
                <td><input type='checkbox' name='delete[$x]' value='$mid'></input></td>
                </tr>";

            $x++;
      
        }

        echo "</table>";

        // HTML Variable for Color Blue
        $vBlue = "\"blue\"";
         // HTML Variable for Color Red
        $vRed = "\"red\"";

        if ($balance > 0){
            echo "Total balance: <font color = '$vBlue'><b>$$balance</font></b>";
        }
        elseif ($balance < 0){
            echo "Total balance: <font color = '$vRed'><b>$$balance</font></b>";
        }
        else{
            echo "<br>Total balance: <b>$$balance</b>";
        }
        
        echo "<br>
        <button id = 'btn' name = 'submitBTN'>Update Transactions</button>";
        echo "</form>";
    }
}else{

if(!isset($_COOKIE)){
                echo "<br>Cookie not set log in again.";
                echo "<br><a href = 'index.html'>Back to Homepage </a>";
            }


}

?>