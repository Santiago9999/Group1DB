<?php

	$inData = getRequestInfo();
	
	$eId = $inData["eId"];
	$title = $inData["title"];
	$description = $inData["description"];
	$url = $inData["url"];
	$startDate = $inData["sDate"];
	$endDate = $inData["eDate"];
	$address = $inData["address"];
	$city = $inData["City"];
	$thing = "just end it";
	$numberHolder = 20;
	//$conn = new mysqli("localhost", "elevenbr_eleventy", "domain password", "database name");
	// connect with server
	$conn = new mysqli("localhost", "grouponedatabase", "KienHua1!", "groupone_Users");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}

	else 
	{	
		
		// Inserting edited Event into DB
		$sql = "UPDATE Events SET title = '" . $title . "', description = '" . $description . "', url = '" . $url . "', sDate = '" . $startDate . "', eDate = '" . $endDate . "', address = '" . $address . "', City = '" . $city . "' where eId = '" . $eId . "'";
		//$sql = "UPDATE Events SET title = '" . $thing . "' where eId = '" . $eId . "'";
		// Check if update was unsuccessful
		if( $result = $conn->query($sql) != TRUE )
		{
			returnWithError($conn->error);
			$conn->close();
		}
		else
		{
			returnWithError("Update Successful");
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