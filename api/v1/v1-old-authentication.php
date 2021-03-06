<?php 


$app->get('/search',function () use ($app) {
	
		$response = array();

		$param_name = $app->request()->params('name');
		$param_key = $app->request()->params('api_key');
		$db = new DbHandler();

		$session = $db->getSession();
		
		$sessionID = $session['uid'];
		$sessionName = $session['name'];
			
		$api_key = $db->getOneRecord("SELECT api_key FROM customers_auth WHERE api_key='$param_key' ");
	    $user = $db->getOneRecord("SELECT name FROM customers_auth WHERE name='$param_name' ");
		
		$credds = $app->credentials;
		

		if ($sessionName != 'Guest' &&  $sessionID != NULL) {
			
			$totalRequestLive = $app->request();
		
			$charset = $app->request->headers->get('Connection');
			$giveHead = $app->request()->headers;
		
			$cookieMonster = $app->getCookie('foo');
			
			//var_dump($app);
			
	        $query = $app->request->get('query');
			$params = $app->request()->params();
			
			
			$response["authorized"] = true;
			$response["sessionId"] = $sessionID;
			$response["sessionName"] = $sessionName;
			
			$response["totalRequestLive"] = $totalRequestLive;
			$response["head"] = $giveHead;
			$response["charset"] = $charset;
			$response["query"] = $query;
			$response["results"] = $params;
	        $response["cookieMonster"] = $cookieMonster;
			
			
			echoResponse(200, $response);	
		} else {
			$response["authorized"] = false;
			echoResponse(401, $response);	
		}

		//header('WWW-Authenticate: Basic realm="Test Authentication System"');
		//header('HTTP/1.0 401 Unauthorized');
		
		
	/*	
		$totalRequestLive = $app->request();
		
		$charset = $app->request->headers->get('Connection');
		$giveHead = $app->request()->headers;
		
		$cookieMonster = $app->getCookie('foo');
		
        $query = $app->request->get('query');
		$params = $app->request()->params();
        $hookObject = (object) ['totalRequestLive' => $totalRequestLive, 'head'=> $giveHead, 'charset'=>$charset, 'query' => $query, 'results' => $params, 'cookieMonster' => $cookieMonster];
		
		
   	 	echoResponse(200, $hookObject);	
		*/
 });


$app->get('/projects', function() use ($app) {
	$response = array();
    $db = new DbHandler();
	
	$session = $db->getSession();
	$sessionID = $session['uid'];
	$sessionName = $session['name'];

	if ($sessionName != 'Guest' &&  $sessionID != NULL) {
		$result = $db->getAllProjects();
		$response["error"] = false;
	    $response["projects"] = array();
	
	
		while($row = $result->fetch_assoc()){
		    $test[] = $row; 
			array_push($response["projects"], $test);
		}	
		echoResponse(200, $response);
	} else {
		$response["true"] = false;
	    $response["auth"] = 'Access denied';
		echoResponse(401, $response);
	}	
		
});


$app->get('/projects/:id', function($proj_id) {
	$response = array();
    $db = new DbHandler();
	
	$session = $db->getSession();
	$sessionID = $session['uid'];
	$sessionName = $session['name'];
	
	if ($sessionName != 'Guest' &&  $sessionID != NULL) {
	    $result = $db->getOneProject($proj_id);
	
		$response["error"] = false;
		$response["proj_id"] = $proj_id;
	    $response["projects"] = array();
	
		array_push($response["projects"], $result->fetch_assoc());	
		echoResponse(200, $response);	
	} else {
		$response["true"] = false;
	    $response["auth"] = 'Access denied';
		echoResponse(401, $response);
	}
	
});

$app->get('/session', function() {
    $db = new DbHandler();
    $session = $db->getSession();
    $response["uid"] = $session['uid'];
    $response["email"] = $session['email'];
    $response["name"] = $session['name'];
    echoResponse(200, $session);
});

$app->post('/login', function() use ($app) {
	
	$app->setCookie('foo', 'bar', '2 days');
	
    require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
    $password = $r->customer->password;
    $email = $r->customer->email;
    $user = $db->getOneRecord("select uid,name,password,email,created from customers_auth where phone='$email' or email='$email'");
    if ($user != NULL) {
        if(passwordHash::check_password($user['password'],$password)){
        $response['status'] = "success";
        $response['message'] = 'Logged in successfully.';
        $response['name'] = $user['name'];
        $response['uid'] = $user['uid'];
        $response['email'] = $user['email'];
        $response['createdAt'] = $user['created'];
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['uid'] = $user['uid'];
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $user['name'];
        } else {
            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect credentials';
        }
    }else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
});

$app->post('/signUp', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'name', 'password'),$r->customer);
    require_once 'passwordHash.php';
    $db = new DbHandler();
	
    $phone = $r->customer->phone;
    $name = $r->customer->name;
    $email = $r->customer->email;
    $address = $r->customer->address;
    $password = $r->customer->password;
	
	
	
	
	
    $isUserExists = $db->getOneRecord("select 1 from customers_auth where phone='$phone' or email='$email'");
    if(!$isUserExists){
        $r->customer->password = passwordHash::hash($password);
		$r->customer->api_key = $db->generateApiKey();

        $tabble_name = "customers_auth";
        $column_names = array('phone', 'name', 'email', 'password', 'api_key', 'city', 'address');
        $result = $db->insertIntoTable($r->customer, $column_names, $tabble_name);
		
		
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["uid"] = $result;
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $response["uid"];
            $_SESSION['phone'] = $phone;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to create customer. Please try again";
            echoResponse(201, $response);
        }            
    }else{
        $response["status"] = "error";
        $response["message"] = "An user with the provided phone or email exists!";
        echoResponse(201, $response);
    }
});
$app->get('/logout', function() {
    $db = new DbHandler();
    $session = $db->destroySession();
    $response["status"] = "info";
    $response["message"] = "Logged out successfully";
    echoResponse(200, $response);
});
?>