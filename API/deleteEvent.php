<?php

	$inData = getRequestInfo();
	
	$eId = $inData["eId"];

	//$conn = new mysqli("localhost", "elevenbr_eleventy", "domain password", "database name");
	// connect with server
	$conn = new mysqli("localhost", "grouponedatabase", "KienHua1!", "groupone_Users");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}

	else 
	{	
		
		$sql = "DELETE FROM Events WHERE eId = '" . $eId . "'";

		// Check if update was unsuccessful
		if( $result = $conn->query($sql) != TRUE )
		{
			returnWithError($conn->error);
		}
		else
		{
			returnWithError("Delete was successful.");
		}
		$conn->close();

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



?>