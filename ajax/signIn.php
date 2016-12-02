<?php

    //header('Content-Type: application/json'); May need this when we bring the code to the server
    // Start the session
	session_start();
    $returnValue = array(0);  //return value for the call

    if(!empty($_POST)){ //Check that we are in a postback
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        //Use this to link to the connections page for the database functions
        require_once('../Globals/connection.php');
        
        if(!$email > 0){ array_push($returnValue, "Please enter email address"); }
        if(!$password > 0){ array_push($returnValue, "Please enter password"); }
        
        if(count($returnValue) < 2){ //Check for errors before signing in the user
			//Get the results from the query (Grabs only one row)
			$results = $conn->query("SELECT `personId` FROM `people` WHERE `email` = '".$email."' AND `password` = ENCRYPT('".$password."','password') AND `status` = 'ACTIVE'  LIMIT 1 ");
			if(!$results){ //If true then there is an error with connection or query
                array_push($returnValue, "ERROR: Connection issue, Please call support");
			}
			//if we have a row then set the session variable for the customer id
			if($results ->num_rows > 0){ //Make sure we have no errors
				//set the session person id variable to be used on other pages to what was returned
				$_SESSION['personId'] = $results->fetch_assoc()['personId'];
				//Now we need to return the value and set the hidden input field
				$returnValue[0] = $_SESSION['personId'];
				
			} else { //Query did not grab any results show alert
			    array_push($returnValue, "Sorry, the username/password is incorrect");
			}
		}
    } else { //for some reason not in postback so send error
        array_push($returnValue, "ERROR: Connection issue, Please call support");
    }
    
    //if everything worked correctly then the array should have just an empty string
    echo json_encode($returnValue);
?>