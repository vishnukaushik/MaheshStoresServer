<?php
 
/*
 * Following code will create a new product row
 * All components details are read from HTTP Post Request
 */
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_GET['CAT_ID']) && isset($_GET['COMP_ID'])) {
 
    $cat_id = $_GET['CAT_ID'];
    $comp_id = $_GET['COMP_ID'];
    
 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
    $con = $db->connect();
 
    // mysql inserting a new row
    $decrement_result = mysqli_query($con, "UPDATE catalogue SET catalogue.COUNT = catalogue.COUNT-1 WHERE catalogue.CAT_ID = $cat_id");

    $delete_result = mysqli_query($con, "DELETE FROM component WHERE component.COMP_ID = $comp_id AND component.CAT_ID = $cat_id");
 
    // check if row inserted or not
    if ($decrement_result && $delete_result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Component removed successfully";
 
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