<?php
 
/*
 * Following code will list all the products
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
$con = $db->connect();

// get all products from products table
$result = mysqli_query($con, "SELECT *FROM transactions") or die(mysqli_error());
 
// check for empty result
if (mysqli_num_rows($result) > 0) {

    // success
    $response["success"] = 1;
    $response["message"] = "Components found";
    // looping through all results
    // products node
    $response["components"] = array();
 
    while ($row = mysqli_fetch_array($result)) {
        // temp user array
        $component = array();
        $component["ID"] = $row["ID"];
        $component["NAME"] = $row["NAME"];
        $component["STUDENT_ID"] = $row["STUDENT_ID"];
        $component["ISSUE_DATE"] = $row["ISSUE_DATE"];
        $component["RETURN_DATE"] = $row["RETURN_DATE"];
 
        // push single component into final response array
        array_push($response["components"], $component);
    }
    
 
    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No components found";
    $response["components"] = array();
 
    // echo no users JSON
    echo json_encode($response);
}
?>