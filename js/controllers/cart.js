main.controller('cartController',['$rootScope','utilities','inform','cartService',function($rootScope,utilities,inform,cartService){
    var self = this;
    
    self.getCoursesToPay = function()
    {
    	return cartService.getCoursesToPay();
    }
    
    self.pay = function(){
    	cartService.pay();
    }
    
    self.getTotalPrice = function(){
    	return cartService.getTotalPrice();
    }
}]);