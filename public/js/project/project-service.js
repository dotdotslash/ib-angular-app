'use strict';

angular.module('myapp')
  .factory('Project', ['$resource', function ($resource) {
    //return $resource('myapp/projects/:id', {}, {
	$resource = $resource('../api/v1/projects/:id', {}, {
		'query': { method: 'GET', isArray: true },
		'get': { method: 'GET'},
		'update': { method: 'PUT'},
		'post': { method: 'POST'}	
    });
	
	return $resource;
	
  }]);
