main.controller('forumController',['utilities','$scope','$http','$server','$routeParams','$timeout','$route','$cookies','inform','$window',function(utilities,$scope,$http,$server,$routeParams,$timeout,$route,$cookies,inform,$window){
    var self = this;
    
    self.forumNewMessage = "";
    
    /* CONFIG */
    self.username = $cookies.get('username');
}]);