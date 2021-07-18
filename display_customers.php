<HTML>

<?php

include "dbconfig.php";

$con = mysqli_connect($dbhostname, $dbusername, $dbpassword, $dbname)
or die("<br>Cannot connect to DB:$dbhostname on CPS3740 Customer Table \n");


$query = "SELECT * FROM Customers";

$result = mysqli_query($con, $query);


echo "The following customers are in the bank system: ";

echo "<TABLE>";  // open the table and start tag

echo "<TABLE border=1>\n
<tr>    
<td>ID</td>
<td>Login</td>
<td>Password</td>
<td>Name</td>
<td>Gender</td>
<td>DOB</td>
<td>Street</td>
<td>City</td>
<td>State</td>
<td>Zipcode</td>
</tr> ";

if($result) { // This is a boolean statement-if Boolean is true, then...


 while($row = mysqli_fetch_array($result)) {


	 	$ID=$row["id"];
        $Login=  $row["login"];
        $Password=  $row["password"];
        $Name =  $row["name"];
        $Gender = $row["gender"];
        $DOB = $row["DOB"];
        $Street= $row["street"];
        $City = $row["city"];
        $State= $row["state"];
        $ZC= $row["zipcode"];

       
		if ($ID <>"") echo "<TR><TD>$ID\n"; 
         if ($Login<>"")  echo "<td>$Login</td>\n"; 
         if ($Password<>"")  echo "<td>$Password</td>\n"; 
        if ($Name <>"")  echo "<td>$Name</td>\n";
        if ($Gender<>"")  echo "<td>$Gender</td>\n";
        if ($DOB<>"")  echo "<td>$DOB</td>\n";
         if ($Street<>"")  echo "<td>$Street</td>\n";
        if ($City<>"")  echo "<td>$City</td>\n";
        if ($State<>"")  echo "<td>$State</td>\n";
        if ($ZC<>"")  echo "<td>$ZC</td>\n";


           


}
echo "</TABLE>\n"; //echo "</table>"; //Close the table in HTML

}


mysqli_close($con);

?>

</HTML>