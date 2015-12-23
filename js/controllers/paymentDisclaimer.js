main.controller('paymentDisclaimerController',['$scope','$location',function($scope,$location){
    var self = this;
    
    self.paymentDisclaimerForm = {};
    
    self.submit = function(){
        $location.path('/confirm_payment');
        $scope.$dismiss();
    };
    
}]);
