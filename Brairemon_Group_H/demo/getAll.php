<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array

$response = array();
$final = array();
$users = $db->getAll();

while($user = $users->fetch_assoc()){

    $response["id"] = $user["U_ID"];
    $response["user"]["name"] = $user["username"];
    $response["user"]["email"] = $user["email"];
    $response["user"]["created_at"] = $user["created_at"];
    array_push($final,$response);
} 
   // $resoponse = $users->fetch_assoc(); 
echo json_encode($final);
?>
