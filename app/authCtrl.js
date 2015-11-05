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
                $location.path('projects');
            }
        });
    };
    
	$scope.signup = {email:'',password:'',name:'',phone:'',address:''};
	    
	$scope.signUp = function (customer) {
		
        Data.post('signUp', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
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
		
	    $scope.sortType     = 'id'; // set the default sort type
		$scope.sortReverse  = false;  // set the default sort order
		$scope.searchFish   = '';     // set the default search/filter term
		
		
		$scope.dynomite_text = 'Next';
		$scope.page_title = 'Add Project';	
		$scope.page_subtitle = '';
		$scope.counter = 0;
		
	    Data.get('session').then(function (results) {
	        Data.toast(results);
			$scope.user = results;
	    });
		
	    $scope.logout = function () {
	        Data.get('logout').then(function (results) {
	            Data.toast(results);
	            $location.path('login');
	        });
	    }
	

		var path = $location.path();
		var routeParam = $routeParams.id;
		
		if(!routeParam){
			routeParam = '';
		} else {
			routeParam = '/'+routeParam;
			
		}
		
		$scope.getProjects = function () {
	        Data.get('projects'+routeParam).then(function (results) {
				$scope.projects = results.projects;
	        });
		};	
		
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
			    default:
			    	console.log('uhhh!');
			}
		};
		
		$scope.goForward = function () {
			$scope.counter += 1;
			console.log($scope.counter);
			$scope.counterSwitch($scope.counter);
		 
		};	
		
		$scope.counterSwitch = function(counter) {
			console.log('Counter: '+counter);			
			switch(counter) {
			    case 0:
					$scope.secondSection = false;
					$scope.accordnHide(1);
					break;
				case 1:
					$scope.dynomite_text = 'Next';
					$scope.secondSection = true;
					$scope.accordnShow(1);
					$scope.page_subtitle = $scope.projects.client;	
					$scope.page_title = $scope.projects.project_name;
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
					$scope.submitProject($scope.projects);
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
			$scope.page_title = $scope.projects.client;	
			$scope.page_subtitle = $scope.projects.project_name;
			$('.accordian-container--1 .form-group').addClass('ng-hide');
			$('.accordian-container--1 .form-output').removeClass('ng-hide');
		
		}
		
		$scope.clear = function () {
			console.log('CLEAR');
			
		    $scope.projects = {
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
		
		if(path == '/projects/add') {
		    $scope.clear();	
		} else {
			$scope.getProjects();
		}

		$scope.submitProject = function (project) {
			console.log('$scope.submitProject  called');
			$scope.projects.submitter = $scope.user.email;
			
	        Data.post('projects', {
	            project: project
	        }).then(function (results) {
	            Data.toast(results);
	            if (results.status == "success") {
	                $location.path('projects');
	            }
	       	});
	    };
		
		$scope.updateProject = function (project) {
	        Data.put('projects', {
	            project: project
	        }).then(function (results) {
	            Data.toast(results);
	            if (results.status == "success") {
	                $location.path('projects');
	            }
	       	});
	    };
		
		$scope.delete = function (id) {
		    Data.delete('projects/'+id).then(function (results) {
		        Data.toast(results);
				$scope.getProjects();
		   	});
			
		};	
}])	