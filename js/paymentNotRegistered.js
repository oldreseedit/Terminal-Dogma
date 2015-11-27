main.controller('paymentNotRegisteredController',['$cookies','$location',function($cookies,$location){
    var self=this;
    
    self.refresh = function(){ 
        if($cookies.get('username')) $location.path('/payment');
    };
    
}]);