'use strict';

angular.module('myapp')
  .controller('ProjectController', ['$scope', '$location', 'resolvedProject', 'Project',
    function ($scope, $location, resolvedProject, Project) {

		$scope.go = function ( path ) {
		  $location.path( path );
		};

		resolvedProject.$promise.then(function (result) {
		   $scope.projects = result.projects;
		});
		
		
		$scope.delete = function (id) {
		Project.delete({id: id},
		  function () {
		    $scope.projects = Project.query();
		  });
		};

		$scope.clear = function () {
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
		};
}])
angular.module('myapp')
  .controller('ProjectTestController', ['$scope', '$location', 'resolvedProject', 'Project',
    function ($scope, $location, resolvedProject, Project) {
		
		$scope.project = {};
		
		$scope.submitProject = function (project) {
			console.log($scope.project);
			
	        Data.post('signUp', {
	            project: project
	        }).then(function (results) {
	            Data.toast(results);
				console.log($scope.signup);
	            if (results.status == "success") {
	                $location.path('dashboard');
	            }
	        });
	    };
		/*
	    $scope.submitProject = function () {

			if($scope.project.completion_date === ''){
				$scope.project.completion_date = '1/1/1980';
			}
			console.log($scope.project);
		
		    Project.save($scope.project, function () {
				console.log($scope.project);
		    	$scope.project = Project.post();
		    });
		  
		//	$location.path('/projects');
		
	    };
		*/
		
}])		

	
angular.module('myapp')
  .controller('ProjectSaveController', ['$scope', '$routeParams', '$location', 'resolvedProject', 'Project',
    function ($scope, $routeParams, $location, resolvedProject, Project) {
	
	$scope.dynomite_text = 'Next';
	$scope.page_title = 'Add Project';	
	$scope.page_subtitle = '';
	$scope.counter = 0;
	
	
	$scope.btn_disabled = true;
	
	$scope.goBack = function () { 
		$scope.counter -= 1;
		console.log('something: '+$scope.counter);
		switch($scope.counter) {
		    case 0:
				$scope.secondSection = false;
				$scope.accordnHide(1);
				break;
			case 1:
				$scope.thirdSection = false;
				$scope.accordnHide(2);
		        break;
		    case 2:
				$scope.fourthSection = false;
				$scope.accordnHide(3);
		        break;
		    case 3:
				$scope.fifthSection = false;
				$scope.accordnHide(4);
		        break;	
		    case 4:
				$scope.sixthSection = false;
				$scope.accordnHide(5);
		        break;	
		    case 5:
				$scope.dynomite_text = 'Submit';
				$scope.sixthSection = false;
				$scope.accordnHide(6);
		        break;
		    case 6:
				$scope.dynomite_text = 'Submitted Test!!!';
				$scope.submitProject();
		        break;				
		    default:
		    	console.log('uhhh!');
		}
		
	};
	
	$scope.goForward = function () {
		$scope.counter += 1;
		console.log($scope.counter);
		console.log($scope.project);
		$scope.counterSwitch($scope.counter);
		 
	};

	$scope.counterSwitch = function(counter) {
		console.log('something: '+counter);
		switch(counter) {
		    case 0:
				console.log('sdfs');
				$scope.secondSection = false;
				$scope.accordnHide(1);
				break;
			case 1:
				$scope.dynomite_text = 'Next';
				$scope.secondSection = true;
				$scope.accordnShow(1);
				
				$scope.page_title = $scope.project.client;	
				$scope.page_subtitle = $scope.project.project_name;
				$scope.btn_disabled = true;
		        break;
		    case 2:
				$scope.dynomite_text = 'Next';
				$scope.thirdSection = true;
				$scope.accordnShow(2);
				$scope.btn_disabled = true;
		        break;
		    case 3:
				$scope.dynomite_text = 'Next';
				$scope.fourthSection = true;
				$scope.accordnShow(3);
				
		        break;	
		    case 4:
				$scope.dynomite_text = 'Next';
				$scope.fifthSection = true;
				$scope.accordnShow(4);
		        break;	
		    case 5:
				$scope.dynomite_text = 'Submit';
				$scope.sixthSection = true;
				$scope.accordnShow(5);
		        break;
		    case 6:
				$scope.dynomite_text = 'Submitted Test!!!';
				$scope.submitProject();
		        break;				
		    default:
		    	console.log('uhhh!');
		}
	}
	
	$scope.accordnShow = function (classNum) {
		$('.accordian-container--'+classNum+' .form-group').addClass('ng-hide');
		$('.accordian-container--'+classNum+' .form-output').removeClass('ng-hide');
	};
	
	$scope.accordnHide = function (classNum) {
		$('.accordian-container--'+classNum+' .form-group').removeClass('ng-hide');
		$('.accordian-container--'+classNum+' .form-output').addClass('ng-hide');
	};
	

	$scope.clear = function () {
		console.log('CLEAR');
			
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
		
	}	

	if($location.path() == '/projects/add'){
		$scope.clear();
	} else {
		$scope.project = Project.get({id: $routeParams.id}); 
		$scope.secondSection = true;
		$scope.thirdSection = true;
		$scope.fourthSection = true;
		$scope.fifthSection = true;
		$scope.sixthSection = true;
	}

	$scope.$watchGroup(['form.client.$valid', 'form.project_name.$valid', 'form.response_due.$valid'], function(newValues, oldValues, scope) {
		$scope.sectionOneBtn = true;
		$scope.btn_disabled = true;
		
		console.log(newValues);
		if(newValues[0] && newValues[1] && newValues[2]) {
			$scope.btn_disabled = false;
		}
	});
	
	$scope.$watchGroup(['form.request_received.$valid', 'form.lead_source.$valid', 'form.client_contact.$valid','form.start_date.$valid'], function(newValues, oldValues, scope) {
		console.log(newValues);
		if(newValues[0] && newValues[1] && newValues[2] && newValues[3]) {
			$scope.btn_disabled = false;
		}
	});
	
	$scope.$watchGroup(['form.project_goal.$valid','form.project_reason.$valid','form.project_success_marker.$valid','form.project_user.$valid'], function(newValues, oldValues, scope) {
		console.log(newValues);
		if(newValues[0] && newValues[1] && newValues[2] && newValues[3]) {
			$scope.btn_disabled = false;
		}
	});
	
	
	$scope.sectionTwo = function() {
		$scope.secondSection = true;
		$scope.page_title = $scope.project.client;	
		$scope.page_subtitle = $scope.project.project_name;
		$('.accordian-container--1 .form-group').addClass('ng-hide');
		$('.accordian-container--1 .form-output').removeClass('ng-hide');
		
	}

    $scope.submitProject = function () {

		if($scope.project.completion_date === ''){
			$scope.project.completion_date = '1/1/1980';
		}
		console.log($scope.project);
		
	    Project.save($scope.project, function () {
			console.log($scope.project);
	    	$scope.project = Project.post();
	    });
		  
	//	$location.path('/projects');
		
    };
	
	
}]);

 
angular.module('myapp')
  .controller('ProjectDetailController', ['$scope', '$routeParams', 'resolvedProject', 'Project',
    function ($scope, $routeParams, resolvedProject, Project) {
	/*	
		console.log(resolvedProject);
		resolvedProject.$promise.then(function (result) {
			
		   $scope.projects = result.projects;
		 	console.log($scope.project);
		});
	 */
		
	$scope.project = Project.get({id: $routeParams.id}); 
	$scope.project.$promise.then(function (result) {		
	   $scope.project = result.projects;
	 	console.log(result.project);
	});
	
	 
	  
}]);