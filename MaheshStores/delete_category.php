<?php
 
/*
 * Following code will delete a component from table
 * A component is identified by id
 */
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_GET['CAT_ID'])) {
    $cat_id = $_GET['CAT_ID'];
 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
$con = $db->connect();
 
    // mysql update row with matched pid
    $result = mysqli_query($con, "DELETE FROM catalogue WHERE CAT_ID = $cat_id");
    
    // check if row deleted or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Category of component successfully deleted";
 
        // echoing JSON response
        echo json_encode($response);
    } else {
        // no component found
        $response["success"] = 0;
        $response["message"] = "No component found";
 
        // echo no users JSON
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