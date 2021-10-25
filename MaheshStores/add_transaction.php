<?php
 
/*
 * Following code will create a new product row
 * All components details are read from HTTP Post Request
 */
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_GET['STUDENT_ID']) && isset($_GET['COMP_ID']) && isset($_GET['RETURN_DATE'])) {
 
    $student_id = $_GET['STUDENT_ID'];
    $component_id = $_GET['COMP_ID'];
    $return_date = $_GET['RETURN_DATE'];
    
    $return_date = strval($return_date);
    $return_date = "\"".$return_date."\"";
 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
    $con = $db->connect();
 
    // mysql inserting a new row
    $result = mysqli_query($con, "INSERT INTO transactions(STUDENT_ID, COMP_ID, RETURN_DATE) VALUES($student_id, $component_id, $return_date)");
 
    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Component lent successfully";
 
        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
 
        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    // echoing JSON response
    echo json_encode($response);
}
?>