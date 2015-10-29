'use strict';

angular.module('myapp')
  .config(['$routeProvider', function ($routeProvider) {
    $routeProvider
	  
      .when('/projects', {
        templateUrl: 'views/project/projects.html',
        controller: 'ProjectController',
        resolve:{
          resolvedProject: ['Project', function (Project) {
            return Project.get();
          }]
        }
      })
    
	  .when('/projects/add', {
        templateUrl: 'views/project/project-add.html',
        controller: 'ProjectSaveController',
        resolve:{
          resolvedProject: ['Project', function (Project) {
            return Project.get();
          }]
        }
      })
	  
	  .when('/projects/edit/:id', {
        templateUrl: 'views/project/project-add.html',
        controller: 'ProjectSaveController',
        resolve:{
          resolvedProject: ['Project', function (Project) {
            return Project.query();
          }]
        }
      })
	  
      .when('/projects/:id', {
        templateUrl: 'views/project/projects-details.html',
        controller: 'ProjectDetailController',
        resolve:{
          resolvedProject: ['Project', function (Project) {
            return Project.get();
          }]
        }
      })
	  
    }]);
