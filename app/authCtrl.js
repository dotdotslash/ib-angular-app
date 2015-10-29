app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    //initially set those objects to null to avoid undefined error
    $scope.login = {};
    
	$scope.signup = {};
    
	$scope.doLogin = function (customer) {
        Data.post('login', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('dashboard');
            }
        });
    };
    
	$scope.signup = {email:'',password:'',name:'',phone:'',address:''};
    
	$scope.signUp = function (customer) {
		
        Data.post('signUp', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
			console.log($scope.signup);
            if (results.status == "success") {
                $location.path('dashboard');
            }
        });
    };
	
    $scope.logout = function () {
        Data.get('logout').then(function (results) {
            Data.toast(results);
            $location.path('login');
        });
    }
});

angular.module('myApp')
  .controller('projectCtrl', ['$scope', '$rootScope', '$routeParams', '$location', '$http', 'Data',
    function ($scope, $rootScope, $routeParams, $location, $http, Data) {
		
	//	$scope.project = {};
	    $scope.project = {
			"id": "",
		    "client": "",
		    "project_name": "",
			"response_due": "",
			"opportunity_size": "",

			"request_received": "",
			"lead_source": "",
			"job_number": "",
			"proposal_format": "",
			"competitive": "",
			"final_decision_maker": "",
			"start_date": "",
			"completion_date": "",
			"timeline_driver": "",
		
			"c_el_business_strategy": false,
			"c_el_research": false,
			"c_el_roadmap": false,
			"c_el_brand_strat": false,
			"c_el_touchpoint": false,
			"c_el_guidelines": false,
			"c_el_go_to_market": false,
			"c_el_channel_priorities": false,
		
			"serv_research": false,
			"serv_b_intelligence": false,
			"serv_b_valuation": false,
			"serv_ex_valuation": false,
		
			"serv_definition": false,
			"serv_strength_mgmt": false,
			"serv_architecture": false,
			"serv_ex_strategy": false,
			"serv_ino_strategy": false,
			"serv_naming": false,
			"serv_citizenship": false,
		
			"serv_gtm": false,
			"serv_mgmt_platform": false,
			"serv_implementation": false,
			"serv_internal_engage": false,
			"serv_m_capdev": false,
			"serv_ux_capdev": false,
		
			"project_goal": "",
			"project_reason": "",
			"project_success_marker": "",
			"project_user": "",
			"primary_service": "",
			"ib_client_lead": "",
			"ib_content_lead": "",
			"ib_sponsor": "",
			"ib_team": "",
			"ib_office_team": "",
			"ib_major_dates": "",
			"ib_industry": "",
			"ib_case_studies": ""

	    };	
		
		$scope.submitProject = function (project) {
			console.log($scope.project);
			
	        Data.post('projects', {
	            project: project
	        }).then(function (results) {
	            Data.toast(results);
				console.log($scope.signup);
	            if (results.status == "success") {
	                $location.path('dashboard');
	            }
	        });
	    };
}])	