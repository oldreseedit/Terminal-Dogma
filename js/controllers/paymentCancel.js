main.controller('paymentCancelController',['utilities','$cookies','$server',function(utilities,$cookies,$server){
    var self = this;
    
    self.removeCookie = function(){$cookies.remove('pendingPayment',{path:'/'});};
    
}]);