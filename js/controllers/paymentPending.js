main.controller('paymentPendingController',['utilities','$routeParams',function(utilities,$routeParams){
    var self = this;
    
    self.paymentID = $routeParams.paymentID;
    self.amount = $routeParams.amount;
    self.paymentCycle = $routeParams.paymentCycle;
    self.paymentMedia = $routeParams.paymentMedia;
    self.wireTransferCode = $routeParams.wireTransferCode;
    self.reason = $routeParams.reason;
    self.holder = $routeParams.holder;
}]);