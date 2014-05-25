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
//echo $sql;

}
?>