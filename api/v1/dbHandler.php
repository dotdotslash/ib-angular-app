<?php

class DbHandler {

    private $conn;

    function __construct() {
        require_once 'dbConnect.php';
        // opening db connection
        $db = new dbConnect();
        $this->conn = $db->connect();
    }
    /**
     * Fetching single record
     */
    public function getOneRecord($query) {
        $r = $this->conn->query($query.' LIMIT 1') or die($this->conn->error.__LINE__);
        return $result = $r->fetch_assoc();    
    }
    /**
     * Creating new record
     */
    public function insertIntoTable($obj, $column_names, $table_name) {
        
        $c = (array) $obj;
        $keys = array_keys($c);
        $columns = '';
        $values = '';
        foreach($column_names as $desired_key){ // Check the obj received. If blank insert blank into the array.
           if(!in_array($desired_key, $keys)) {
                $$desired_key = 'a';
            }else{
                $$desired_key = $c[$desired_key];
            }
            $columns = $columns.$desired_key.',';
            $values = $values."'".$$desired_key."',";
        }
        $query = "INSERT INTO ".$table_name."(".trim($columns,',').") VALUES(".trim($values,',').")";
        $r = $this->conn->query($query) or die($this->conn->error.__LINE__);

        if ($r) {
            $new_row_id = $this->conn->insert_id;
            return $new_row_id;
            } else {
            return NULL;
        }
    }
	      
public function getAllProjects() {
	$stmt = $this->conn->prepare("SELECT * FROM Projects");
   	$stmt->execute();
    $tasks = $stmt->get_result();
	$stmt->close();
    return $tasks;
}

public function getOneProject($proj_id) {
	$stmt = $this->conn->prepare("SELECT * FROM Projects WHERE id = $proj_id");
   	$stmt->execute();
    $tasks = $stmt->get_result();
	$stmt->close();
    return $tasks;
}
	
public function getSession(){
    if (!isset($_SESSION)) {
        session_start();
    }
    $sess = array();
    if(isset($_SESSION['uid']))
    {
        $sess["uid"] = $_SESSION['uid'];
        $sess["name"] = $_SESSION['name'];
        $sess["email"] = $_SESSION['email'];
    }
    else
    {
        $sess["uid"] = '';
        $sess["name"] = 'Guest';
        $sess["email"] = '';
    }
    return $sess;
}
public function destroySession(){
    if (!isset($_SESSION)) {
    session_start();
    }
    if(isSet($_SESSION['uid']))
    {
        unset($_SESSION['uid']);
        unset($_SESSION['name']);
        unset($_SESSION['email']);
        $info='info';
        if(isSet($_COOKIE[$info]))
        {
            setcookie ($info, '', time() - $cookie_time);
        }
        $msg="Logged Out Successfully...";
    }
    else
    {
        $msg = "Not logged in...";
    }
    return $msg;
}




	
public function getApiKeyById($user_id) {
    $stmt = $this->conn->prepare("SELECT api_key FROM user_auth WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $api_key = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $api_key;
    } else {
        return NULL;
    }
}
public function getUserId($api_key) {
    $stmt = $this->conn->prepare("SELECT id FROM user_auth WHERE api_key = ?");
    $stmt->bind_param("s", $api_key);
    if ($stmt->execute()) {
        $user_id = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user_id;
    } else {
        return NULL;
    }
}
public function isValidApiKey($api_key) {
    $stmt = $this->conn->prepare("SELECT id from user_auth WHERE api_key = ?");
    $stmt->bind_param("s", $api_key);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();
    return $num_rows > 0;
}


public function generateApiKey() {
	return md5(uniqid(rand(), true));
}

 
}

?>
