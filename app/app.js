var app = angular.module('myApp', ['ngRoute', 'ngAnimate', 'toaster','ui.date']);

app.config(['$routeProvider',
  function ($routeProvider) {
        $routeProvider.
	        when('/login', {
	            title: 'Login',
	            templateUrl: 'partials/login.html',
	            controller: 'authCtrl'
	        })
            .when('/logout', {
                title: 'Logout',
                templateUrl: 'partials/login.html',
                controller: 'logoutCtrl'
            })
            .when('/signup', {
                title: 'Signup',
                templateUrl: 'partials/signup.html',
                controller: 'authCtrl'
            })
            .when('/dashboard', {
                title: 'Dashboard',
                templateUrl: 'partials/dashboard.html',
                controller: 'authCtrl'
            })
            .when('/projects', {
                title: 'Projects',
                templateUrl: 'partials/projects.html',
                controller: 'projectCtrl'
            })
            .when('/projects/add', {
                title: 'Projects',
                templateUrl: 'partials/project-add.html',
                controller: 'projectCtrl'
            })
            .when('/projects/:id', {
                title: 'Projects',
                templateUrl: 'partials/project-details.html',
                controller: 'projectCtrl'
            })
            .when('/projects/:id/edit', {
                title: 'Projects',
                templateUrl: 'partials/project-edit.html',
                controller: 'projectCtrl'
            })
			/*
            .when('/', {
                title: 'Login',
                templateUrl: 'partials/login.html',
                controller: 'authCtrl',
                role: '0'
            })
			*/
            .otherwise({
                redirectTo: '/projects'
            });
  }])
    .run(function ($rootScope, $location, Data) {
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            $rootScope.authenticated = false;
            Data.get('session').then(function (results) {
                if (results.uid) {
                    $rootScope.authenticated = true;
                    $rootScope.uid = results.uid;
                    $rootScope.name = results.name;
                    $rootScope.email = results.email;
                } else {
                    var nextUrl = next.$$route.originalPath;
                    if (nextUrl == '/signup' || nextUrl == '/login') {

                    } else {
                        $location.path("/login");
                    }
                }
            });
        });
    });