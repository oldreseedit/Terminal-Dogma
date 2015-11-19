main.controller('paymentCancelController',['utilities','$cookies','$http',function(utilities,$cookies,$http){
    var self = this;
    
    self.removeCookie = function(){$cookies.remove('pendingPayment',{path:'/'});};
    
}]);