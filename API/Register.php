<?php

	$inData = getRequestInfo();
	
	// Named after database fields
	//$whols = $inData["whols"];
	$firstName = $inData["fName"];
	$lastName = $inData["lName"];
	$plainPassword = $inData["password"];
	//$hashedPassword = "";
	$email = $inData["email"];
	$phoneNum = $inData["phone"];

	//$conn = new mysqli("localhost", "username for database", "domain password", "database name");
	$conn = new mysqli("localhost", "grouponedatabase", "KienHua1!", "groupone_Users");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	
	else 
	{
		//$hashedPassword = password_hash( $plainPassword , PASSWORD_DEFAULT);
		// Check whether User is in User DB table before allowing them to register
		$sql = "SELECT fName,lName FROM User where email='" . $email . "'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0)
		{	
			returnWithError("That email is Already Taken");
		}
		else
		{
			// Inserting newly registered user into User DB table
			$sql = "INSERT into User (fName,lName,email,password,phone) VALUES ('" . $firstName . "','" . $lastName . "','" . $email . "','" . $plainPassword . "','" . $phoneNum . "')";
			returnWithError("Insert successful");
			// Check if insertion was unsuccessful
			if( $result = $conn->query($sql) != TRUE )
			{
				returnWithError( $conn->error );
			}

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
		$retValue = '{"login":"","firstName":"","lastName":"","password":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>