<?php
    $conn = openConnection();
/**
 *This function opens a temporary connection and then returns the connection  
 * It uses an optional database so that we can change the database names when we want to open the 
 * the performance database or statistical database to look at stats for analytics
 * 
 */
function openConnection($database = "strictly_shirts"){
    //For some reason php does not like these to be public
    //So put them in here
    $serverName = "localhost";
    $userName = "strictlyShirts";
    $password = "strictlyShirts";
    
    $temporaryConnection = new mysqli($serverName,$userName,$password,$database);
    
    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    return $temporaryConnection;
}


?>