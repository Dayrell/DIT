<?php
 
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
$response = array("error" => FALSE);
 
if (isset($_POST['username']) && isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['password'])) {
 
    $username = $_POST['username'];
	$fullname = $_Post['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    if ($db->isUserExisted($email)) {
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with " . $email;
        echo json_encode($response);
    } else {
        $user = $db->storeStudent($username, $fullname, $email, $password);
        if ($user) {
            $response["error"] = FALSE;
            $response["id"] = $user["id"];
            $response["user"]["name"] = $user["name"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["created_at"] = $user["created_at"];
            echo json_encode($response);
        } else {
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email or password) is missing!";
    echo json_encode($response);
}
?>
