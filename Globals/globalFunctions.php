<?php
    
    
    $globalFunctionsConn = new mysqli("localhost","strictlyShirts","strictlyShirts","strictly_shirts");
    
    //Function that gets the persons first name
    function getPersonsName($personId){
        $results = $globalFunctionsConn->query("SELECT `firstName` FROM `people` WHERE `personId` = ".$personId . " LIMIT 1");
        return $results->fetch_assoc()['firstName'];
    }
    
    /**
     * This function creates the HTML for a closable bootstrap alert
     * Takes in the message and type of alert by default it sets it to danger
     * 
     * TYPES OF alerts
     * 
     * success = Green
     * info = Blue
     * warning = Yellow
     * danger = red
     */
    function addAlert($message, $type = "danger"){
        if(strlen(trim($message)) > 0){
            return "<div class=\"alert  alert-". trim(strtolower($type)) ."\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>". $message ."</div>";
        }
    }
?>