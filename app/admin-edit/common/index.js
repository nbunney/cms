/**
 * Common/index.js
 * This is where all the services, resources, directives, etc, are included
 */

angular
  .module('app:common', ['app:common'])
  .factory('Page', require('./resources/page'))
  .config(function($httpProvider){
    var interceptor = ['$rootScope', '$location', '$q', '$injector', function($rootScope, $location, $q, $injector) {
      return{
        'request': function(config){
          return config;
        },
        'response': function(response){
          return response;
        },
        'responseError': function(response){
          if(response.data.status.code == 422)
            return;
          $rootScope.errors = response.data;
          $injector.get('$state').go('error.generic', [], {location: false});
          return $q.reject(response);
        }
      }
    }];

    $httpProvider.interceptors.push(interceptor);
    // $locationProvider.hashPrefix('/!');

    // $httpProvider.interceptors.push(function(interceptor) {
    //   console.log(interceptor)
    //   return {
    //    'request': function(config) {
    //        // var $root = angular.element("#view").scope();
    //        // $root.globalMessage = false;
    //        // $root.networkActive = {title:'One moment...'}
    //        return config;
    //     },
     
    //     'response': function(response) {
    //        // var $root = angular.element("#view").scope();
    //        // $root.networkActive = false;
    //        return response;
    //     },
    //     'responseError': httpInterceptor.responseError
    //   };
    // });
  })
