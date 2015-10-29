<?php

require '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'angslim',
    'username'  => 'root',
    'password'  => 'root',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$app = new \Slim\Slim();

$app->get('/', function() use ($app) {
    readfile('index.html');
    $app->stop();
});


/* ***********************
	PROJECTS
*********************** */
$app->get('/myapp/projects', function() {
    $projects = Project::all();
    echo $projects->toJson();
});

$app->get('/myapp/projects/:id', function($id) use($app) {
    $project = Project::find($id);
    if (is_null($project)) {
        $app->response->status(404);
        $app->stop();
    }
    echo $project->toJson();    
});

$app->post('/myapp/projects', function() use($app) {
    $body = $app->request->getBody();
    $obj = json_decode($body);
    $project = new Project;
    
	//Opportunity
    $project->client = $obj->{'client'};
    $project->project_name = $obj->{'project_name'};
	$project->response_due = $obj->{'response_due'};
	$project->opportunity_size = $obj->{'opportunity_size'};
	
	//Details
	$project->request_received = $obj->{'request_received'};
	$project->lead_source = $obj->{'lead_source'};
	$project->client_contact = $obj->{'client_contact'};
	$project->proposal_format = $obj->{'proposal_format'};
	$project->job_number = $obj->{'job_number'};
	$project->competitive = $obj->{'competitive'};
	$project->final_decision_maker = $obj->{'final_decision_maker'};
	$project->start_date = $obj->{'start_date'};
	//$project->completion_date = $obj->{'completion_date'};
	$project->timeline_driver = $obj->{'timeline_driver'};
		
		//Client provided elements
	    $project->c_el_business_strategy = $obj->{'c_el_business_strategy'};
	    $project->c_el_research = $obj->{'c_el_research'};
	    $project->c_el_roadmap = $obj->{'c_el_roadmap'};	
	    $project->c_el_brand_strat = $obj->{'c_el_brand_strat'};
	    $project->c_el_touchpoint = $obj->{'c_el_touchpoint'};
	    $project->c_el_guidelines = $obj->{'c_el_guidelines'};
	    $project->c_el_go_to_market = $obj->{'c_el_go_to_market'};
	    $project->c_el_channel_priorities = $obj->{'c_el_channel_priorities'};
	
	
	
	//Details
	$project->project_goal = $obj->{'project_goal'};
	$project->project_reason = $obj->{'project_reason'};
	$project->project_success_marker = $obj->{'project_success_marker'};
	$project->project_user = $obj->{'project_user'};
	
	//Services
	$project->primary_service = $obj->{'primary_service'};
		// Additional Services
		$project->serv_research = $obj->{'serv_research'};
		$project->serv_b_intelligence = $obj->{'serv_b_intelligence'};
		$project->serv_b_valuation = $obj->{'serv_b_valuation'};
		$project->serv_ex_valuation = $obj->{'serv_ex_valuation'};
		
		$project->serv_definition = $obj->{'serv_definition'};
		$project->serv_strength_mgmt = $obj->{'serv_strength_mgmt'};
		$project->serv_architecture = $obj->{'serv_architecture'};
		$project->serv_ex_strategy = $obj->{'serv_ex_strategy'};
		$project->serv_ino_strategy = $obj->{'serv_ino_strategy'};
		$project->serv_naming = $obj->{'serv_naming'};
		$project->serv_citizenship = $obj->{'serv_citizenship'};
	
		$project->serv_ex_design = $obj->{'serv_ex_design'};
		$project->serv_id_design = $obj->{'serv_id_design'};
		$project->serv_environment = $obj->{'serv_environment'};
		$project->serv_packaging = $obj->{'serv_packaging'};
		$project->serv_ux = $obj->{'serv_ux'};
		$project->serv_servdesign = $obj->{'serv_servdesign'};
		$project->serv_messaging = $obj->{'serv_messaging'};
		$project->serv_voice = $obj->{'serv_voice'};
		$project->serv_content_strat = $obj->{'serv_content_strat'};
		$project->serv_content_create = $obj->{'serv_content_create'};
		
		$project->serv_gtm = $obj->{'serv_gtm'};
		$project->serv_mgmt_platform = $obj->{'serv_mgmt_platform'};
		$project->serv_implementation = $obj->{'serv_implementation'};
		$project->serv_internal_engage = $obj->{'serv_internal_engage'};
		$project->serv_m_capdev = $obj->{'serv_m_capdev'};
		$project->serv_ux_capdev = $obj->{'serv_ux_capdev'};
		
	
	//Team
	$project->ib_client_lead = $obj->{'ib_client_lead'};
	$project->ib_content_lead = $obj->{'ib_content_lead'};
	$project->ib_sponsor = $obj->{'ib_sponsor'};
	$project->ib_team = $obj->{'ib_team'};
	$project->ib_office_team = $obj->{'ib_office_team'};
	
	//IB Next steps
	$project->ib_major_dates = $obj->{'ib_major_dates'};
	$project->ib_industry = $obj->{'ib_industry'};
	$project->ib_case_studies = $obj->{'ib_case_studies'};
	
	
    $project->save();
    $app->response->status(201);
    echo $project->toJson();    
});

$app->put('/myapp/projects/:id', function($id) use($app) {
    $body = $app->request->getBody();
    $obj = json_decode($body);
    $project = Project::find($id);
    if (is_null($project)) {
        $app->response->status(404);
        $app->stop();
    }
    
	//Opportunity
    $project->client = $obj->{'client'};
    $project->project_name = $obj->{'project_name'};
	$project->response_due = $obj->{'response_due'};
	$project->opportunity_size = $obj->{'opportunity_size'};
	
	//Details
	$project->request_received = $obj->{'request_received'};
	$project->lead_source = $obj->{'lead_source'};
	$project->client_contact = $obj->{'client_contact'};
	$project->proposal_format = $obj->{'proposal_format'};
	$project->job_number = $obj->{'job_number'};
	$project->competitive = $obj->{'competitive'};
	$project->final_decision_maker = $obj->{'final_decision_maker'};
	$project->start_date = $obj->{'start_date'};
	$project->completion_date = $obj->{'completion_date'};
	$project->timeline_driver = $obj->{'timeline_driver'};
		
		//Client provided elements
	    $project->c_el_business_strategy = $obj->{'c_el_business_strategy'};
	    $project->c_el_research = $obj->{'c_el_research'};
	    $project->c_el_roadmap = $obj->{'c_el_roadmap'};	
	    $project->c_el_brand_strat = $obj->{'c_el_brand_strat'};
	    $project->c_el_touchpoint = $obj->{'c_el_touchpoint'};
	    $project->c_el_guidelines = $obj->{'c_el_guidelines'};
	    $project->c_el_go_to_market = $obj->{'c_el_go_to_market'};
	    $project->c_el_channel_priorities = $obj->{'c_el_channel_priorities'};
	
	
	
	//Details
	$project->project_goal = $obj->{'project_goal'};
	$project->project_reason = $obj->{'project_reason'};
	$project->project_success_marker = $obj->{'project_success_marker'};
	$project->project_user = $obj->{'project_user'};
	
	//Services
	$project->primary_service = $obj->{'primary_service'};
		// Additional Services
		$project->serv_research = $obj->{'serv_research'};
		$project->serv_b_intelligence = $obj->{'serv_b_intelligence'};
		$project->serv_b_valuation = $obj->{'serv_b_valuation'};
		$project->serv_ex_valuation = $obj->{'serv_ex_valuation'};
		
		$project->serv_definition = $obj->{'serv_definition'};
		$project->serv_strength_mgmt = $obj->{'serv_strength_mgmt'};
		$project->serv_architecture = $obj->{'serv_architecture'};
		$project->serv_ex_strategy = $obj->{'serv_ex_strategy'};
		$project->serv_ino_strategy = $obj->{'serv_ino_strategy'};
		$project->serv_naming = $obj->{'serv_naming'};
		$project->serv_citizenship = $obj->{'serv_citizenship'};
	
		$project->serv_ex_design = $obj->{'serv_ex_design'};
		$project->serv_id_design = $obj->{'serv_id_design'};
		$project->serv_environment = $obj->{'serv_environment'};
		$project->serv_packaging = $obj->{'serv_packaging'};
		$project->serv_ux = $obj->{'serv_ux'};
		$project->serv_servdesign = $obj->{'serv_servdesign'};
		$project->serv_messaging = $obj->{'serv_messaging'};
		$project->serv_voice = $obj->{'serv_voice'};
		$project->serv_content_strat = $obj->{'serv_content_strat'};
		$project->serv_content_create = $obj->{'serv_content_create'};
		
		$project->serv_gtm = $obj->{'serv_gtm'};
		$project->serv_mgmt_platform = $obj->{'serv_mgmt_platform'};
		$project->serv_implementation = $obj->{'serv_implementation'};
		$project->serv_internal_engage = $obj->{'serv_internal_engage'};
		$project->serv_m_capdev = $obj->{'serv_m_capdev'};
		$project->serv_ux_capdev = $obj->{'serv_ux_capdev'};
		
	
	//Team
	$project->ib_client_lead = $obj->{'ib_client_lead'};
	$project->ib_content_lead = $obj->{'ib_content_lead'};
	$project->ib_sponsor = $obj->{'ib_sponsor'};
	$project->ib_team = $obj->{'ib_team'};
	$project->ib_office_team = $obj->{'ib_office_team'};
	
	//IB Next steps
	$project->ib_major_dates = $obj->{'ib_major_dates'};
	$project->ib_industry = $obj->{'ib_industry'};
	$project->ib_case_studies = $obj->{'ib_case_studies'};
	
    $project->save();
    echo $project->toJson();    
});

$app->delete('/myapp/projects/:id', function($id) use($app) {
    $project = Project::find($id);
    if (is_null($project)) {
        $app->response->status(404);
        $app->stop();
    }
    $project->delete();
    $app->response->status(204);
});


/* ***********************
	USERS
*********************** */

$app->get('/myapp/users', function() {
    $users = User::all();
    echo $users->toJson();
});

$app->get('/myapp/users/:id', function($id) use($app) {
    $user = User::find($id);
    if (is_null($user)) {
        $app->response->status(404);
        $app->stop();
    }
    echo $user->toJson();    
});

$app->post('/myapp/users', function() use($app) {
    $body = $app->request->getBody();
    $obj = json_decode($body);
    $user = new User;
    
    $user->name = $obj->{'name'};
	$user->email = $obj->{'email'};
	$user->admin = $obj->{'admin'};
	
    $user->save();
    $app->response->status(201);
    echo $user->toJson();    
});

$app->put('/myapp/users/:id', function($id) use($app) {
    $body = $app->request->getBody();
    $obj = json_decode($body);
    $user = User::find($id);
    if (is_null($user)) {
        $app->response->status(404);
        $app->stop();
    }
    
    $user->name = $obj->{'name'};
	$user->email = $obj->{'email'};
    $user->admin = $obj->{'admin'};
    $user->save();
    echo $user->toJson();    
});

$app->delete('/myapp/users/:id', function($id) use($app) {
    $user = User::find($id);
    if (is_null($user)) {
        $app->response->status(404);
        $app->stop();
    }
    $user->delete();
    $app->response->status(204);
});


/* ***********************
	RUN
*********************** */
$app->run();
