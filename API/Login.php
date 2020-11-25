<?php

	$inData = getRequestInfo();

	$id = 0;
	$firstName = "";
	$lastName = "";
	$whoIs = -1;
	$email = $inData["email"];
	$password = $inData["password"];

	$conn = new mysqli("localhost", "grouponedatabase", "KienHua1!", "groupone_Users");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	
	else
	{
		//Does user exist in database
		$sql = "SELECT uId,fName,lName,whoIs FROM User where email='" . $email . "'";
		
		$result = $conn->query($sql);
		if ($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			$firstName = $row["fName"];
			$lastName = $row["lName"];
			$id = $row["uId"];
			$whoIs = $row["whoIs"];
			//$password = $row["password"];
		}
		else
		{
			returnWithError( "No Records Found" );
			$conn->close();
		}
		//check their password versus it's hash
		/*if (password_verify($password, $hashedPassword))
			returnWithInfo($firstName, $lastName, $id );
		else
		{
			returnWithError( "Passwords don't match" );
		}
		*/
		
		// BREAKs CODE
		
		if (strcmp($password,$row["password"]))
			returnWithInfo($firstName, $lastName, $id, $whoIs );
		else
		{
			returnWithError( "Passwords don't match" );
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

	function returnWithInfo( $firstName, $lastName, $id, $whoIs )
	{

		$retValue = '{"id":"' . $id . '","firstName":"' . $firstName . '","lastName":"' . $lastName . '","whoIs":"' . $whoIs . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>
