<?php
class DB_Functions {

	private $conn;

	function __construct(){
		require_once 'DB_Connect.php';
		$db = new DB_Connect();
		$this-> conn = $db->connect();
	}

	function __destruct(){
	}

	public function storeStudent($sUsername,$sFullName, $email, $password){
		
		$hash = $this->hashSSHA($password);
		$encrypted_password = $hash["encrypted"];
		$salt = $hash["salt"];

		$stmt = $this->conn->prepare("INSERT INTO users (username, fullName , email, hash_password, salt, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
		$stmt->bind_param("sssss", $sUsername, $sFullName, $email, $encrypted_password, $salt);
		$result = $stmt->execute();
		$stmt->close();

		if($result){
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
			$stmt->bind_param("s",$email);
			$stmt->execute();
			$user = $stmt->get_result()->fetch_assoc();
			$stmt->close();
		
			return $user;
		}else{
			return false;
		}
		

	}

	 public function getUserByEmailAndPassword($email, $password) {
 
        	$stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
       		$stmt->bind_param("s", $email);
 
        	if ($stmt->execute()) {
            		$user = $stmt->get_result()->fetch_assoc();
            		if($user['encrypted_password'] == $this->checkhashSSHA($user['salt'],$password)){
				$stmt->close();
            			return $user;
			}else{
                        	$stmt->close();
				return NULL;
			}
       		} else {
            		return NULL;
        	}
    	}

	public function isUserExisted($email) {
	        
		$stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");
	        $stmt->bind_param("s", $email);
	        $stmt->execute();
        	$stmt->store_result();
 
       		if ($stmt->num_rows > 0) { 
            		$stmt->close();
            		return true;
       		} else {
            		$stmt->close();
            		return false;
        	}
    	}


    	public function hashSSHA($password) {
 
        	$salt = sha1(rand());
        	$salt = substr($salt, 0, 10);
        	$encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        	$hash = array("salt" => $salt, "encrypted" => $encrypted);
       		return $hash;
   	 }

	public function checkhashSSHA($salt, $password) {
 
        	$hash = base64_encode(sha1($password . $salt, true) . $salt);
 		 return $hash;
   	 }

	public function getAll(){
                $stmt = $this->conn->prepare("SELECT * FROM users");
		if($stmt->execute()){
                        $users = $stmt->get_result();
			$stmt->close();
                        return $users;
                }else{
			return false;
		}

        }
	public function getIDByEmail($email){
		$stmt = $this->conn->prepare("SELECT * from users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
                $stmt->close();

		return $user["id"];;

	}
}
?>



