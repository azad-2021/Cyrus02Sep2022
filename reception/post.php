
<?php

include 'connection.php';
include 'session.php';
$ID=$_SESSION['userid'];
// Fetching Values From URL

$BranchCode = $_POST['branch'];
$Type = $_POST['type'];
$GadgetID = $_POST['device'];
$ReceivedBy = $_POST['receivedby'];
$MadeBy = $_POST['madeby'];
$InfoDate = $_POST['infodate'];
$ExpDate = $_POST['expected'];
$Discription =$_POST['discription'];


if ($Type=='Complaint') {
	$sql = "INSERT INTO complaints (BranchCode, Discription, DateOfInformation, ExpectedCompletion, ReceivedBY, MadeBy, GadgetID)
	VALUES ('$BranchCode', '$Discription', '$InfoDate', '$ExpDate', '$ReceivedBy', '$MadeBy', '$GadgetID')";
	$msg='<script>alert("Complaint added")</script>';
}elseif ($Type=='Order') {
	$sql2 = "INSERT INTO orders (BranchCode, Discription, DateOfInformation, ExpectedCompletion, ReceivedBy, OrderedBy, GadgetID)
	VALUES ('$BranchCode', '$Discription', '$InfoDate', '$ExpDate', '$ReceivedBy', '$MadeBy', '$GadgetID')";
	if ($con->query($sql2) === TRUE) {
		if(strpos($Discription, 'AMC') !== false){
			$Status=5;   
		}else{
			$Status=1;
		}
		$OrderID=$con->insert_id;
		$sql = "INSERT INTO demandbase (StatusID, OrderID, GeneratedByID, DemandGenDate)
		VALUES ('$Status', '$OrderID', '$ID', '$InfoDate')";
		$msg='<script>alert("order added")</script>';
	}else {
		echo "Error: " . $sql2 . "<br>" . $con->error;

	}
	$OrderID = $con->insert_id;

}


if ($con->query($sql) === TRUE) {

}else {
	echo "Error: " . $sql . "<br>" . $con->error;
	$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $con->error);
	fclose($myfile);
}


?>
