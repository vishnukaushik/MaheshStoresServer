<?php
 
/*
 * Following code will create a new product row
 * All components details are read from HTTP Post Request
 */
 
// array for JSON response
$response = array();
 
// check for required fields

if (isset($_POST['USER_ID']) && isset($_POST['PASSWORD'])) {
 
    $user_id = $_POST['USER_ID'];
    $password = $_POST['PASSWORD'];

    $hashed_password = strval(password_hash($password, PASSWORD_BCRYPT));
    $hashed_password = "\"".$hashed_password."\"";

 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
    $con = $db->connect();
 
    // mysql inserting a new row
    $result = mysqli_query($con, "INSERT INTO authentication(authentication.USER_ID, authentication.PASSWORD) VALUES($user_id,$hashed_password)");
 
    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Admin added successfully";
 
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