
<?php

include "dbconfig.php";

 $con = mysqli_connect($dbhostname, $dbusername, $dbpassword, $dbname)
 or die("<br>Cannot connect to DB:$dbhostname on Customers CPS3740 Database \n");

// If the Cookie ID is set
if(isset($_COOKIE['ID'])) {

    
$id=$_COOKIE['ID'];

$name=$_COOKIE['customer_name'];
     
$valueToSearch= $_GET['SearchWord'];

 $sqlquery="SELECT * 
 FROM CPS3740_2021S1.Money_brodavia m,CPS3740.Sources s 
 WHERE m.cid = $id
 AND m.sid = s.id
 ORDER BY m.mid desc "; // Showing all transactions?
        
 $result = mysqli_query($con,$sqlquery);

// Boolen if Result is True 

    if($valueToSearch =='*'){

      
        echo "The transaction in the customer <b> ".$name." </b> records matched keywords are '*' ."; // Could change back to Strong 
            

            if($result) {

                if(mysqli_num_rows($result)>0) {


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
                    
                    while($row = mysqli_fetch_array($result)) {


                        $ID= $row["mid"];
                        $code = $row["code"];
                        $type =$row["type"];
                        $amount=$row["amount"];
                        $mydatetime = $row["mydatetime"];
                        $Source=$row['name'];
                        $note = $row["note"];



                        if($row['type'] == 'W'){

                            $tdStyle = 'red';

                         } elseif($row['type'] == 'D'){
                            $tdStyle = 'blue';
                        }
            
                      
                      echo "<tr><td>" . $ID. "</td><td>" . $code . "</td><td>" . $type. " <td style= color:{$tdStyle};'>{$row['amount']}</td>"."</td><td>". $Source

. "</td><td>". $mydatetime. "</td><td>" . $note. "</td></tr>";

                        }
                
                }

                 echo "</TABLE>\n";

            }
            // If Empty or No Value It should output this that No Keyword was entered
   
    } elseif (empty($valueToSearch) || $valueToSearch == " ") {

        echo "No Keyword was entered.";

    } 


// If statement has something 
    else {
        
        $queryT= "SELECT * FROM 
        CPS3740_2021S1.Money_brodavia m,CPS3740.Sources s  WHERE m.cid = $id AND m.sid = s.id  
        AND note LIKE CONCAT('%".$valueToSearch."%')
        order by m.mid asc";
        
        $noteResult = mysqli_query($con, $queryT);
            
        if($noteResult) {

            if(mysqli_num_rows($noteResult) > 0) {
              
                echo "The transaction in the customer <b> ".$name." </b> records matched keywords <b> '$valueToSearch' </b>are: <br>";
                 echo "<TABLE width='1000'>"; 
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

                while($row = mysqli_fetch_array($noteResult)) {
                  
                        $ID= $row["mid"];
                        $code = $row["code"];
                        $type =$row["type"];
                        $amount=$row["amount"];
                        $Source=$row['name'];
                        $mydatetime = $row["mydatetime"];
                        $note = $row["note"];

                        if($row['type'] == 'W'){

                            $tdStyle = 'red';

                         } elseif($row['type'] == 'D'){
                            $tdStyle = 'blue';
                        }
            
                  
                     if ($ID <>"") echo "<TR><TD>$ID\n"; 
                     if ($code <>"")  echo "<td>$code</td>\n"; 
                    if ($type <>"")  echo "<td>$type</td>\n";
                    if ($Source<>"")  echo "<td>$Source</td>\n";

                     
                   //  echo ""
                    echo " <td style= color:{$tdStyle};'>{$row['amount']}</td>";
                    //echo "<td>".$Source."</td>";
                    if ($mydatetime<>"")  echo "<td>$mydatetime</td>\n";

                    if ($note<>"")  echo "<td>$note</td>\n";


                }
            } else {
                echo "No record found with the search keyword: <b> ".$valueToSearch. "</b>";
            }
        } else {
            echo "No result found";
        }
    }
} else if(!isset($_COOKIE['ID'])){
    echo "Cookie Not Set! Error!";
    echo "Please click <a href='index.html'>here (project home page)</a> to login again.<br><br>";
}

mysqli_close($con);


?>