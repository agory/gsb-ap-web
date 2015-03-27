// js/todoList.js
'use strict';

var app = angular.module('MonApp', ['ngRoute']);
app.config(function($routeProvider) {
    $routeProvider
            .when('/', {templateUrl:'partials/home.html'})
            .when('/practitioners', {templateUrl:'partials/practitioners.html', controller:'PractitionersCtrl'})
            .otherwise({redirectTo:'/'})
});
var url = 'http://gsb-ap.dev/json/';

app.factory('PractitionerFact', function($http,$q){
    var factory = {
        getPractitioners : function(){
            var deferred = $q.defer();
            $http.get(url + 'practitioner/all')
                    .success(function(data, status){
                        deferred.resolve(data);
                    }).error(function(data, status){
                        deferred.reject('Impossible de récupérer les articles');
                    });
            return deferred.promise;
        },
        getPractitioner : function(id){
            
            var deferred = $q.defer();
            $http.get(url + 'practitioner/id')
                    .success(function(data, status){
                        deferred.resolve(data);
                    }).error(function(data, status){
                        deferred.reject('Impossible de récupérer les articles');
                    });
            return deferred.promise;
        },
        
    }
    return factory;
})

app.controller('PractitionersCtrl', function($scope, PractitionerFact) {
        $scope.loading = 'non';
        $scope.practitioners = PractitionerFact.getPractitioners().then(function(practitioners){
            $scope.practitioners = practitioners;
            $scope.loading = 'oui';
        }, function(msg){
            alert(msg);
        });
    }
);
