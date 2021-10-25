<?php
 

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
$con = $db->connect();
 
// check for post data
if (isset($_GET["STUDENT_ID"])) {
    $student_id = $_GET['STUDENT_ID'];
 
    // get a components from components table
    $result = mysqli_query($con, "SELECT transactions.ID AS ID, transactions.STUDENT_ID, transactions.COMP_ID AS COMPONENT_ID, catalogue.NAME, transactions.ISSUE_DATE, transactions.RETURN_DATE from ((transactions JOIN component on component.COMP_ID=transactions.COMP_ID) JOIN catalogue on catalogue.CAT_ID=component.CAT_ID) WHERE transactions.STUDENT_ID = $student_id");
    
    if (!empty($result)) {
        // check for empty result
        if (mysqli_num_rows($result) > 0) {
            
            // success
            $response["success"] = 1;
            $response["message"] = "components found!";
            
            $response["components"] = array();
            // looping through all results
            // components node   
            while ($row = mysqli_fetch_array($result)) {
                // temp user array
                $component = array();
                $component["ID"] = $row["ID"];
                $component["STUDENT_ID"] = $row["STUDENT_ID"];
                $component["COMPONENT_ID"] = $row["COMPONENT_ID"];
                $component["NAME"] = $row["NAME"];
                $component["ISSUE_DATE"] = $row["ISSUE_DATE"];
                $component["RETURN_DATE"] = $row["RETURN_DATE"];
         
                // push single component into final response array
                array_push($response["components"], $component);
            }
            // echo json_encode($response);
        }
        else
        {
            $response["success"] = 0;
            $response["message"] = "No component found!";
            $response["components"] = array();
        }

        // echo no users JSON
        echo json_encode($response);
    
    } else {
        // no components found
        $response["success"] = 0;
        $response["message"] = "Check your Student ID";
        $response["components"] = array();

        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
    $response["components"] = array();
        // echoing JSON response
    echo json_encode($response);
}
?>