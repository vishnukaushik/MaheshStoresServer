<?php
 
/*
 * Following code will create a new product row
 * All category details are read from HTTP Post Request
 */
 
// array for JSON response
$response = array();
 

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();
$con = $db->connect();

// mysql inserting a new row
$result = mysqli_query($con, "SELECT CAT_ID, NAME FROM catalogue");

if (mysqli_num_rows($result) > 0) {

    // success
    $response["success"] = 1;
    $response["message"] = "Categories found";
    // looping through all results
    // products node
    $response["category"] = array();
 
    while ($row = mysqli_fetch_array($result)) {
        // temp user array
        $category= array();
        $category["CAT_ID"] = $row["CAT_ID"];
        $category["NAME"] = $row["NAME"];
 
        // push single categoryinto final response array
        array_push($response["category"], $category);
    }
    
 
    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No Categories found";
    $response["category"] = array();
 
    // echo no users JSON
    echo json_encode($response);
}


?>