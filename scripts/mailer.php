<?php
	error_reporting(0);
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$name = $_REQUEST["name"];
		$email = $_REQUEST["email"];
		$comment = $_REQUEST["comment"];
		if(trim($name) != "" && trim($email) != "" && trim($comment) != ""){
			$name = hackProof(ucwords(strtolower($name)));
			$email = hackProof($email);
			$comment = hackProof($comment);
			
			/* check for NAME validation*/
			if(!isString($name)){
				
				$a[0] = "bug";
				$a[1] = "Enter Valid Name";
				
			} else if(strlen($name) > 200){
				
				$a[0] = "bug";
				$a[1] = "Name should be less than 200";
				
			}
			
			/* check for EMAIL validation*/
			if(!isEmail($email)){
				
				$a[0] = "bug";
				$a[2] = "Enter Valid Email";
				
			} else if(strlen($email) > 200){
				
				$a[0] = "bug";
				$a[2] = "Email should be less than 200";
				
			}
			
			/* check for MESSAGE/COMMENT validation*/
			if(strlen($comment) < 50 || strlen($comment) > 1500){
				
				$a[0] = "bug";
				$a[3] = "Message should be between 50 and 1500 characters";
				
			}	
			
			/* checks if there is no bug then executes*/
			if( !isset($a[0]) ){
				
				//$conn = new mysqli("localhost", "rahuljun", "password@!@#", "rahuljun_db");
				$conn = new mysqli("localhost", "rahuljun", "2580085210@Rj", "rahuljun_db");
				// Check connection

				$sql = "INSERT INTO rj_msgs (name, email, message)
				VALUES ('$name', '$email', '$comment')";

				if ($conn->query($sql) === TRUE) {
					$a = array("success", "Your email has been sent");
					
				} else {
					$a = array("error", "There's a problem in connecting to network.");
					
				}
				$conn->close();

			}
			
		} else {
			$a[0] = "bug";
			if(trim($name) == ""){
				$a[1] = "Enter Your Name";
			} else if(!isString($name)){
				$a[1] = "Enter Valid Name";
			} else if(strlen($name) > 200){
				$a[1] = "Name should be less than 200";	
			}
			
			if(trim($email) == ""){
				$a[2] = "Enter Email";
			} else if(!isEmail($email)){
				$a[2] = "Enter Valid Email";
			} else if(strlen($email) > 200){
				$a[2] = "Email should be less than 200";
			}
			
			if(trim($comment) == ""){
				$a[3] = "Enter Message";
			} else if(strlen($comment) < 50 || strlen($comment) > 1500){
				$a[3] = "Message should be between 50 and 1500 characters";
			}	
		}
		
		echo json_encode($a);
	} else {
		//header("Loaction:http://www.rahuljuneja.host-ed.me");
		$a = array("error", "page not executed");
		echo json_encode($a);
		
	}
	
	function isString( $var ){
		if(preg_match("/^[a-zA-Z ]*$/", $var)){ return true; } else { return false; }
	}
	
	function isEmail( $var ){
		if(filter_var($var, FILTER_VALIDATE_EMAIL)){ return true; } else { return false; }
	}
	function hackProof( $var ){
		return htmlentities(trim($var));
	}
?>