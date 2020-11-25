<?php

	$inData = getRequestInfo();

	// Named after database fields for a new contact
	$whols = $inData["whols"];
	$eId = $inData["eId"];
	$approvedPlacedHolder = 1;
	$zeroPlaceHolder = 0;
	
	//$conn = new mysqli("localhost", "elevenbr_eleventy", "domain password", "database name");
	// connect with server
	$conn = new mysqli("localhost", "grouponedatabase", "KienHua1!", "groupone_Users");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else{
		//Are they superadmin
		if($whols == $zeroPlaceHolder)
		{
			// change status from 0 to 1
			$sql = "UPDATE Events SET status = '" . $approvedPlacedHolder . "' where eId = '" . $eId . "'";
			// Check if approve was unsuccessful
			if( $result = $conn->query($sql) != TRUE )
			{
				returnWithError($conn->connect_error);
				$conn->close();
			}
			else
			{
				returnWithError("Update successful");
				$conn->close();
			}
		}
		else
		{
			returnWithError("Improper credentials");
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
	
?>