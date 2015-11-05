
	  
<!doctype html>
<html lang="en" ng-app="myApp">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Opportunity Tracker</title>
  <link href="lib/bootstrap-css/css/bootstrap.css" rel="stylesheet"/>
  <link href="lib/jquery-ui/themes/smoothness/jquery-ui.css" rel="stylesheet"/>
  <link href="css/toaster.css" rel="stylesheet"/>
  <link href="css/app.css" rel="stylesheet"/>
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
  
</head>
<body ng-cloak="">
			
		
		<div class="container" ng-view></div>
      
    </body>
  <toaster-container toaster-options="{'time-out': 1000}"></toaster-container>
  <!-- Libs -->
  
  <script src="lib/jquery/dist/jquery.js"></script>
  <script src="lib/jquery-ui/jquery-ui.js"></script>
 
   <!-- 
  <script src="js/angular.min.js"></script> -->
  
  <script src="lib/angular/angular.js"></script>
  
  <script src="lib/angular-ui-date/src/date.js"></script>
  <script src="lib/lodash/dist/lodash.js"></script>


  
  
  

  <script src="lib/angular-resource/angular-resource.js"></script>
  <script src="lib/angular-route/angular-route.js"></script>
  <script src="lib/angular-bootstrap/ui-bootstrap-tpls.js"></script>
  
  
  <script src="lib/angular-animate/angular-animate.js"></script>

	 <script src="lib/angular-bootstrap/ui-bootstrap-tpls.js"></script> 
	   
 <!--   <script src="js/angular-animate.min.js" ></script> -->
  
  
  

  <script src="js/toaster.js"></script>
  
  <script src="app/app.js"></script>
  <script src="app/data.js"></script>
  <script src="app/directives.js"></script>
  <script src="app/authCtrl.js"></script>
</html>

