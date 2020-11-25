<?php

	$inData = getRequestInfo();
	$id = $inData["uId"];
	$onePlaceHolder = 1;
	
	$conn = new mysqli("localhost", "grouponedatabase", "KienHua1!", "groupone_Users");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		//Does user exist in database
		$sql = "SELECT * FROM Events where status='" . $onePlaceHolder . "' AND hId='". $id ."' ORDER BY sDate ASC, eDate ASC";
		$result = $conn->query($sql);
		if( $result != TRUE )
		{
			returnWithError($conn->error);
			$conn->close();
		}
		
		else if ($result->num_rows > 0)
		{	
			while($row = $result->fetch_assoc())
			{
				if ($numResults > 0)
				{
					$searchResults .= ",";
				}
				$numResults++;
				$searchResults .= '"' . $row["title"] . '",';
				$searchResults .= '"' . $row["description"] . '",';
				$searchResults .= '"' . $row["url"] . '",';
				$searchResults .= '"' . $row["sDate"] . '"';
				$searchResults .= '"' . $row["eDate"] . '",';
				$searchResults .= '"' . $row["address"] . '",';
				$searchResults .= '"' . $row["eId"] . '",';
				$searchResults .= '"' . $row["City"] . '"';
				$searchResults .= '"' . $row["hId"] . '"';
			}
			
			returnWithInfo($searchResults);
		}
		else
		{
			returnWithError("No events happening in your area, check back soon!");
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

	function returnWithInfo($searchResults)
	{
		$retValue = '{"results":[' . $searchResults . ']}';
		sendResultInfoAsJson( $retValue );
	}

?>