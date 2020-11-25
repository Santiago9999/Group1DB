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
		//put uId and eId into Isin
		$sql = "INSERT into isIn (eId,uId) VALUES ('" . $eId . "','" . $id . "')";
		if( $result = $conn->query($sql) != TRUE )
		{
			returnWithError($conn->error);
			$conn->close();
		}
		else
		{
			returnWithError("User added to event successfully");
			$conn->close();
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