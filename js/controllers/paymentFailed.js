main.controller('paymentFailedController',['utilities','$routeParams',function(utilities,$routeParams){
    var self = this;
    
    self.errorCode = $routeParams.errorCode;
}]);