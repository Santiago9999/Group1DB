<?php

	$inData = getRequestInfo();
	
	$eId = $inData["eId"];
	$id = $inData["uId"];

	//$conn = new mysqli("localhost", "elevenbr_eleventy", "domain password", "database name");
	// connect with server
	$conn = new mysqli("localhost", "grouponedatabase", "KienHua1!", "groupone_Users");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}

	else 
	{	
		//make sure right person is trying to edit
		$sql = "SELECT uId FROM isIn where eId='" . $eId . "'";
		
		$result = $conn->query($sql);
		if ($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			if($id == $row["uId"])
			{
				returnWithError("Correct credentials");
				$conn->close();
			}
			else
			{
				returnWithError("Invalid credentials, please only edit your own events");
			}
			
		}
		else
		{
			returnWithError("Event doesn't exist");
		}

	}


	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}

	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo($firstName, $lastName, $email, $phoneNumber)
	{
		$retValue = '{"firstName":"' . $firstName . '","lastName":"' . $lastName . '","email":' . $email . ',"phoneNumber":' . $phoneNumber . ',"error":""}';
		sendResultInfoAsJson( $retValue );
	}

?>