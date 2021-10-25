<?php
 
/*
 * Following code will update a component information
 * A component is identified by ID
 */
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_GET['CAT_ID'])) {
 
    $CAT_ID = $_GET['CAT_ID'];
 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
    $con = $db->connect();
 
    // mysql update row with matched pid
    $count_result = mysqli_query($con, "SELECT COUNT(*) as RESERVED from ((transactions JOIN component on component.COMP_ID=transactions.COMP_ID) JOIN catalogue on catalogue.CAT_ID=component.CAT_ID) WHERE catalogue.CAT_ID = $CAT_ID");
 
    $total_result = mysqli_query($con, "SELECT cat.count as TOTAL from catalogue as cat where cat.CAT_ID = $CAT_ID");

    $total = mysqli_fetch_array($total_result)["TOTAL"];
    $count = mysqli_fetch_array($count_result)["RESERVED"];

    

    // check if row inserted or not
    if ($total_result && $count_result) {

        $response["success"] = 1;
        $response["message"] = "component available";

        // $available = $total - $count;
        $response["available"] = $total - $count;
 
        // echoing JSON response
        echo json_encode($response);
    } else {
        // required field is missing
        $response["success"] = 0;
        $response["message"] = "Invalid inputs";
        $response["available"] = 0;
     
        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
    $response["available"] = 0;
 
    // echoing JSON response
    echo json_encode($response);
}
?>