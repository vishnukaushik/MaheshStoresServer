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


    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
    $con = $db->connect();
 
    // mysql inserting a new row
    $result = mysqli_query($con, "SELECT * FROM authentication WHERE USER_ID = $user_id");
 
    // check if row inserted or not
    if (mysqli_num_rows($result)==1) {
        // successfully inserted into database
        $response["success"] = 0;
        $row = mysqli_fetch_array($result);

        $actual_user_id = $row["USER_ID"];
        $hashed_password = $row["PASSWORD"];

        if(password_verify($password, $hashed_password))
        {
            $response["success"] = 1;
            $response["message"] = "Admin logged in successfully";
        }
        else
            $response["message"] = "Wrong UserId or Password. Try Again!";
 
        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "UserId does not exits. Try Again!";
 
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