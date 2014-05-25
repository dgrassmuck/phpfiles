<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Polling Places</title>
<style type="text/css">
table {
	margin: 8px;
}

th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 1.2em;
	background: #666;
	color: #FFF;
	padding: 2px 6px;
	border-collapse: separate;
	border: 1px solid #000;
}

td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 1.2em;
	border: 1px solid #DDD;
	padding: 3px;
}
#col1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 1.2em;
	border: 1px solid #DDD;
	background-color: #ccc;
	padding: 2px;
}
textarea {
	font-family: Arial, Helvetica, sans-serif;
}
</style>
</head>
<body>

<?php
function ppSave()
{
echo "Record has been saved";
echo "<br />       PollID : ".$_POST['pID'];
echo "<br />Polling Place : ".$_POST['pp'];
echo "<br />      Address : ".$_POST['precaddr'];
echo "<br />     Address2 : ".$_POST['precaddr2'];
echo "<br />         City : ".$_POST['preccity'];
echo "<br />          Zip : ".$_POST['preczip'];
echo "<br />   Place Name : ".$_POST['pollname'];
echo "<br />      Comment : ".$_POST['comment']."<br />";
}

function check_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function createsql()  {
global $sql;
$newpid = $_POST['pID'];
//$newpp = mysqli_real_escape_string(check_input($_POST['pp']));
$newpp = mysqli_real_escape_string($conn,check_input($_POST['pp']));
//$newAddr = mysqli_real_escape_string(check_input($_POST['precaddr']));
//$newAddr2 = mysqli_real_escape_string(check_input($_POST['precaddr2']));
//$newcity = mysqli_real_escape_string(check_input($_POST['preccity']));
//$newzip = mysqli_real_escape_string(check_input($_POST['preczip']));
$newpollname = mysqli_real_escape_string($conn, check_input($_POST['pollname']));
//$newcomment = mysqli_real_escape_string(check_input($_POST['comment']));
$newcomment = mysqli_real_escape_string($conn, check_input($_POST['comment']));

$sql = "UPDATE tblpollingplace ";
$sql = $sql . "SET PollingPlace = '$newpp', ";
$sql = $sql . "PrecAddr = '$newAddr', ";
$sql = $sql . "PrecAddr2 = '$newAddr2', ";
$sql = $sql . "PrecCity = '$newcity',";
$sql = $sql . "PrecZip = '$newzip', ";
$sql = $sql . "PollName = '$newpollname', ";
$sql = $sql . "Comment = '$newcomment' ";
$sql = $sql . "WHERE PollID = '$newpid'";
echo $sql;
}

$rowtoedit = $_POST['choice'];
$cstart = strpos($rowtoedit,".");

$rowtoedit = substr($rowtoedit,$cstart +1);

//debug point to see what the choice is
//echo $_POST['choice'];

$btnchoice = substr($_POST['choice'],0,4);
switch ($btnchoice)  {
	case "LIST":
		header("Location:pplace.php");
		break;
	case "FORM":
		header("Location:pplaceForm.php");
		break;
}
//echo "GOING TO EDIT VIEW --- edit row -- ".$_POST['choice'];

if ($btnchoice == "EDIT") {
//echo "this is edit mode<br />";
echo "<h1>EDIT POLLING PLACE DETAILS</h1>";
echo "<br />Edit Poll ID -- ".$rowtoedit;

//database connection and query
include ('ppdb.php');

$querystring = "SELECT PollID, PollingPlace, PrecAddr, PrecAddr2, PrecCity, PrecZip, PollName, Comment FROM tblpollingplace WHERE PollID =\"$rowtoedit \"";
$rset = $conn->query($querystring) or die($conn->error._LINE_);
//form display
	echo "<form action=\"pplaceEdit.php\" method=\"post\">";

	echo "<table><tr><th>FIELD</th><th>VALUE</th></tr>";

	($row = $rset->fetch_assoc());

//	echo "<tr><td>".$row['PollingPlace'] . "</td></tr>";
	echo "<tr>";
	echo "<td id=\"col1\">Poll ID</td><td><input type=\"hidden\" size=\"3\" name=\"pID\" value=\"". $row['PollID']."\"/>" ."</td></tr>" ;
	echo "<tr><td id=\"col1\">Polling Place</td><td><input type=\"text\" size=\"50\" name=\"pp\" value=\"". $row['PollingPlace']."\"/>" . "</td></tr>" ;
	echo "<tr><td id=\"col1\">Address</td><td><input type=\"text\" size=\"50\" name=\"precaddr\" value=\"".  $row['PrecAddr'] . "\"/>" . "</td></tr>" ;
	echo "<tr><td id=\"col1\">Address2</td><td><input type=\"text\" size=\"50\" name=\"precaddr2\" value=\"".  $row['PrecAddr2'] . "\"/>"."</td></tr>" ;
	echo "<tr><td id=\"col1\">City</td><td><input type=\"text\" size=\"15\" name=\"preccity\" value=\"". $row['PrecCity'] . "\"/>" . "</td></tr>" ;
	echo "<tr><td id=\"col1\">Zip</td><td><input type=\"text\" size=\"5\"name=\"preczip\" value=\"". $row['PrecZip'] . "\"/>"."</td></tr>" ;
	echo "<tr><td id=\"col1\">Poll Name</td><td><input type=\"text\" size=\"40\" name=\"pollname\" value=\"". $row['PollName'] . "\"/>" . "</td></tr>" ;
	echo "<tr><td id=\"col1\">Comment</td><td><textarea rows = \"4\" cols = \"40\" name=\"comment\">" . $row['Comment']. "</textarea>" . "</td></tr>" ;
	echo "</table><br />";

//	echo "Debug point: " . $row['PollingPlace'] . " -- " . $row['PrecAddr'] . "<br />"

echo "<input type=\"submit\" name=\"choice\" value=\"SAVE\">";
echo "  OR  ";
echo "<input type=\"submit\" name=\"choice\" value=\"FORM VIEW\">";
echo "  OR  ";
echo "<input type=\"submit\" name=\"choice\" value=\"LIST VIEW\">";
echo "</form>";

}
//SAVE only
else {
   
//    ppsave();
include "ppdb.php";
global $sql;
$newpid = $_POST['pID'];
$newpp = mysqli_real_escape_string($conn, check_input($_POST['pp']));
$newpp = mysqli_real_escape_string($conn,check_input($_POST['pp']));
$newAddr = mysqli_real_escape_string($conn, check_input($_POST['precaddr']));
$newAddr2 = mysqli_real_escape_string($conn, check_input($_POST['precaddr2']));
$newcity = mysqli_real_escape_string($conn, check_input($_POST['preccity']));
$newzip = mysqli_real_escape_string($conn, check_input($_POST['preczip']));
$newpollname = mysqli_real_escape_string($conn, check_input($_POST['pollname']));
$newcomment = mysqli_real_escape_string($conn, check_input($_POST['comment']));

$sql = "UPDATE tblpollingplace ";
$sql = $sql . "SET PollingPlace = '$newpp', ";
$sql = $sql . "PrecAddr = '$newAddr', ";
$sql = $sql . "PrecAddr2 = '$newAddr2', ";
$sql = $sql . "PrecCity = '$newcity',";
$sql = $sql . "PrecZip = '$newzip', ";
$sql = $sql . "PollName = '$newpollname', ";
$sql = $sql . "Comment = '$newcomment' ";
$sql = $sql . "WHERE PollID = '$newpid'";
echo $sql . "<br />";
	
	if($conn->query($sql)=== false)  {
	   echo "<br />";
	   trigger_error('Problem SQL: ' . $sql . ' Error: ');
	   echo "<br />";
	}
ppsave();

	echo "<br /><br /><br /><form action=\"pplaceEdit.php\" method=\"post\">";
	echo "<input type=\"submit\" name=\"choice\" value=\"FORM VIEW\">";
	echo "  OR  ";
	echo "<input type=\"submit\" name=\"choice\" value=\"LIST VIEW\">";
	echo "</form>";
}
mysqli_close($conn);
echo "</body></html>";

?>
