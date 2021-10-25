<?php
 
/*
 * Following code will update a component information
 * A component is identified by ID
 */
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_GET['COMP_ID']) && isset($_GET['DATE'])) {
 
    $comp_id = $_GET['COMP_ID'];
    $date = $_GET['DATE'];
    $date = strval($date);
    $date = "\"".$date."\"";
    // echo $date;
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
    $con = $db->connect();
 
    // mysql update row with matched pid
    $result = mysqli_query($con, "UPDATE transactions SET transactions.RETURN_DATE = $date WHERE transactions.COMP_ID = $comp_id");
 
    // check if row inserted or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Component successfully updated.";
 
        // echoing JSON response
        echo json_encode($response);
    } else {
        // not successful
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