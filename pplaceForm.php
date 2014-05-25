<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Polling Places</title>
<style type="text/css">

.paginate {
font-family: Arial, Helvetica, sans-serif;
font-size: .7em;
}
p {
  font-family: Arial, Helvetica, sans-serif;
  font-size: .7em;
  margin-left: 8px;
}

a.paginate {
border: 1px solid #000080;
padding: 2px 6px 2px 6px;
text-decoration: none;
color: #000080;
}

a.paginate:hover {
background-color: #000080;
color: #FFF;
text-decoration: underline;
}

a.current {
border: 1px solid #000080;
font: bold .7em Arial,Helvetica,sans-serif;
padding: 2px 6px 2px 6px;
cursor: default;
background:#000080;
color: #FFF;
text-decoration: none;
}

span.inactive {
border: 1px solid #999;
font-family: Arial, Helvetica, sans-serif;
font-size: .7em;
padding: 2px 6px 2px 6px;
color: #999;
cursor: default;
}

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

</style>
</head>
<body>

<?php
include "PollingPlacepaginator.class.php";
include "ppdb.php";

// Make your database connection here and retrieve your total number of   -- quick select query
$rs=$conn->query("SELECT PollID FROM tblpollingplace WHERE mid(PollID,1,1)<>\"X\"");

echo "<h1>POLLING PLACE FORM VIEW</H1>";

$pages = new Paginator;
$pages->items_total = $rs->num_rows;
//echo "Pages->items total ".$pages->items_total . "<br />";
$pages->mid_range = 7;
$pages->paginate();
echo $pages->display_pages();

// Make your db query here. Include $pages->limit as described in step 8.

$querystring = "SELECT PollID, PollingPlace, PrecAddr, PrecAddr2, PrecCity, PrecZip, PollName, Comment FROM tblpollingplace WHERE mid(PollID,1,1)<>\"X\"".$pages->limit;
$rset = $conn->query($querystring) or die($conn->error._LINE_);
// echo "<br />SQL string: " .$querystring . "<br />";
// echo "MY Pages limit " .$pages->limit . "<br />";
$db_count = $rset->num_rows; 

// echo "MY Number of rows - " . $db_count;
//(i.e. SELECT id,fname,lname FROM employees $pages->limit)

	echo "<table><tr><th>FIELD</th><th>VALUE</th></tr>";

	($row = $rset->fetch_assoc());
	$rowtoedit = $row['PollID'];
	echo "<tr>";
	echo "<td id=\"col1\">Poll ID</td><td>". $row['PollID'] . "</td></tr>" ;
	echo "<tr><td id=\"col1\">Polling Place</td><td>". $row['PollingPlace'] . "</td></tr>" ;
	echo "<tr><td id=\"col1\">Address</td><td>". $row['PrecAddr'] . "</td></tr>" ;
	echo "<tr><td id=\"col1\">Address2</td><td>". $row['PrecAddr2'] . "</td></tr>" ;
	echo "<tr><td id=\"col1\">City</td><td>". $row['PrecCity'] . "</td></tr>" ;
	echo "<tr><td id=\"col1\">Zip</td><td>". $row['PrecZip'] . "</td></tr>" ;
	echo "<tr><td id=\"col1\">Poll Name</td><td>". $row['PollName'] . "</td></tr>" ;
	echo "<tr><td id=\"col1\">Comment</td><td>". $row['Comment'] . "</td></tr>" ;

//echo "Page $pages->current_page of $pages->num_pages";
//echo $pages->display_pages(); // Optional call which will display the page numbers after the results.
echo $pages->display_jump_menu(); // Optional – displays the page jump menu
echo $pages->display_items_per_page(); //Optional – displays the items per page menu
echo "</table><br />";
echo "<p>Page $pages->current_page of $pages->num_pages</p>";
echo "<form action=\"pplaceEdit.php\" method=\"post\">";
echo "<input type=\"submit\" name=\"choice\" value=\"LIST VIEW\">";
echo "  OR  ";
echo "<input type=\"submit\" name=\"choice\" value=\"EDIT CURRENT.$rowtoedit\">";
echo "</form>";

//CLOSE CONNECTION
mysqli_close($conn);

?>
</body>
</html>