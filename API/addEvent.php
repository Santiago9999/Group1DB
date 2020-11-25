<?php

	$inData = getRequestInfo();

	// Named after database fields for a new contact
	$title = $inData["title"];
	$description = $inData["description"];
	$url = $inData["url"];
	$startDate = $inData["sDate"];
	$endDate = $inData["eDate"];
	$address = $inData["address"];
	$city = $inData["City"];
	$id = $inData["uId"];

	//$conn = new mysqli("localhost", "elevenbr_eleventy", "domain password", "database name");
	// connect with server
	$conn = new mysqli("localhost", "grouponedatabase", "KienHua1!", "groupone_Users");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else{
		// Inserting new event into Events DB table
		$sql = "INSERT into Events (title,description,url,sDate,eDate,address,status,City,hId) VALUES ('" . $title . "','" . $description . "','" . $url . "','" . $startDate . "','" . $endDate . "','" . $address . "','" . 0 . "','" . $city . "','" . $id . "')";

		// Check if insertion was unsuccessful
		if( $result = $conn->query($sql) != TRUE )
		{
			returnWithError( $conn->error );
		}
		else
		{
			returnWithError("Insertion successful");
			/*
			//re-query the event to get eId
			$sql = "SELECT eId FROM Events where title='" . $title . "' AND description='" . $description . "' AND url='" . $url . "' AND sDate='" . $startDate . "' AND eDate='" . $endDate . "' AND address='" . $address . "' AND status='" . 0 . "' AND City='" . $city . "'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0)
			{
				$row = $result->fetch_assoc();
				$eId = $row["eId"];
			}
			//put uId and eId into Isin
			
			$sql = "INSERT into isIn (eId,uId) VALUES ('" . $eId . "','" . $id . "')";
			if( $result = $conn->query($sql) != TRUE )
			{
				returnWithError( $conn->error );
			}
			else 
			{
				returnWithError("isIn insertion successful");
			}
			*/
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