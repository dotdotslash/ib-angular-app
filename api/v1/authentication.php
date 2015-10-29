<?php 


$app->get('/search',function () use ($app) {
	
		$response = array();

		$param_name = $app->request()->params('name');
		$param_key = $app->request()->params('api_key');
		$db = new DbHandler();

		$session = $db->getSession();
		
		$sessionID = $session['uid'];
		$sessionName = $session['name'];
			
		$api_key = $db->getOneRecord("SELECT api_key FROM user_auth WHERE api_key='$param_key' ");
	    $user = $db->getOneRecord("SELECT name FROM user_auth WHERE name='$param_name' ");
		
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
		    $test = $row; 
			array_push($response["projects"], $test);
		}	
		
		echoResponse(200, $response);
	} else {
		$response["true"] = false;
	    $response["auth"] = 'Access denied';
		echoResponse(401, $response);
	}	
		
});


$app->post('/projects', function() use ($app) {
	$response = array();
	$r = json_decode($app->request->getBody());
	$db = new DbHandler();
	
    $client = $r->project->client;
    $project_name = $r->project->project_name;
    $response_due = $r->project->response_due;
    $opportunity_size = $r->project->opportunity_size;
	
	$lead_source = $r->project->lead_source;
	$job_number = $r->project->job_number;
	$proposal_format = $r->project->proposal_format;
	$competitive = $r->project->competitive;
	$final_decision_maker = $r->project->final_decision_maker;
	$start_date = $r->project->start_date;
	$completion_date = $r->project->completion_date;
	$timeline_driver = $r->project->timeline_driver;
	
	$project_goal = $r->project->project_goal;
	$project_reason = $r->project->project_reason;
	$project_success_marker = $r->project->project_success_marker;
	$project_user = $r->project->project_user;	
		$c_el_business_strategy = $r->project->c_el_business_strategy;
		$c_el_research = $r->project->c_el_research;
		$c_el_roadmap = $r->project->c_el_roadmap;
		$c_el_brand_strat = $r->project->c_el_brand_strat;
		$c_el_touchpoint = $r->project->c_el_touchpoint;
		$c_el_guidelines = $r->project->c_el_guidelines;
		$c_el_go_to_market = $r->project->c_el_go_to_market;
		$c_el_channel_priorities = $r->project->c_el_channel_priorities;
		
	$primary_service = $r->project->primary_service;
		
	$serv_research = $r->project->serv_research;
	$serv_b_intelligence = $r->project->serv_b_intelligence;
	$serv_b_valuation = $r->project->serv_b_valuation;
	$serv_ex_valuation = $r->project->serv_ex_valuation;

	$serv_definition = $r->project->serv_definition;
	$serv_strength_mgmt = $r->project->serv_strength_mgmt;
	$serv_architecture = $r->project->serv_architecture;
	$serv_ex_strategy = $r->project->serv_ex_strategy;
	$serv_ino_strategy = $r->project->serv_ino_strategy;
	$serv_naming = $r->project->serv_naming;
	$serv_citizenship = $r->project->serv_citizenship;

	$serv_gtm = $r->project->serv_gtm;
	$serv_mgmt_platform = $r->project->serv_mgmt_platform;
	$serv_implementation = $r->project->serv_implementation;
	$serv_internal_engage = $r->project->serv_internal_engage;
	$serv_m_capdev = $r->project->serv_m_capdev;
	$serv_ux_capdev = $r->project->serv_ux_capdev;	
		
        $tabble_name = "projects";
        $column_names = array(
			
		'client', 'project_name', 'response_due', 'opportunity_size',
		
		'lead_source',
		'job_number',
		'proposal_format',
		'competitive',
		'final_decision_maker',
		'start_date',
		'completion_date',
		'timeline_driver',
		
		'project_goal',
		'project_reason',
		'project_success_marker',
		'project_user',
			'c_el_business_strategy',
			'c_el_research',
			'c_el_roadmap',
			'c_el_brand_strat',
			'c_el_touchpoint',
			'c_el_guidelines',
			'c_el_go_to_market',
			'c_el_channel_priorities',
		
		'primary_service',
	
		'serv_research',
		'serv_b_intelligence',
		'serv_b_valuation',
		'serv_ex_valuation',

		'serv_definition',
		'serv_strength_mgmt',
		'serv_architecture',
		'serv_ex_strategy',
		'serv_ino_strategy',
		'serv_naming',
		'serv_citizenship',

		'serv_gtm',
		'serv_mgmt_platform',
		'serv_implementation',
		'serv_internal_engage',
		'serv_m_capdev',
		'serv_ux_capdev'
						
		);
        
		$result = $db->insertIntoTable($r->project, $column_names, $tabble_name);
		
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["uid"] = $result;
            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to create project. Please try again";
            echoResponse(201, $response);
        }            

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
	
    $isUserExists = $db->getOneRecord("select 1 from user_auth where phone='$phone' or email='$email'");
    if(!$isUserExists){
        $r->customer->password = passwordHash::hash($password);
		$r->customer->api_key = $db->generateApiKey();

        $tabble_name = "user_auth";
        $column_names = array('phone', 'name', 'email', 'password', 'api_key', 'city', 'address');
        $result = $db->insertIntoTable($r->customer, $column_names, $tabble_name);
		
		
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["uid"] = $result;
		/*
			// Start session of user after signup
		    if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $response["uid"];
            $_SESSION['phone'] = $phone;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
		*/
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
	    $response["projects"] = $result->fetch_assoc();
	
		//array_push($response["projects"], $result->fetch_assoc());	
		
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
    $user = $db->getOneRecord("select uid,name,password,email,created,approved from user_auth where phone='$email' or email='$email'");
    if ($user != NULL) {
        if(passwordHash::check_password($user['password'],$password) &&  $user['approved'] == 1 ){
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
        } else if($user['approved'] == 0) {
            $response['status'] = "error";
            $response['message'] = 'Admin has not approved access.';
        }
			else {
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
	
    $isUserExists = $db->getOneRecord("select 1 from user_auth where phone='$phone' or email='$email'");
    if(!$isUserExists){
        $r->customer->password = passwordHash::hash($password);
		$r->customer->api_key = $db->generateApiKey();

        $tabble_name = "user_auth";
        $column_names = array('phone', 'name', 'email', 'password', 'api_key', 'city', 'address');
        $result = $db->insertIntoTable($r->customer, $column_names, $tabble_name);
		
		
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["uid"] = $result;
		/*
			// Start session of user after signup
		    if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $response["uid"];
            $_SESSION['phone'] = $phone;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
		*/
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