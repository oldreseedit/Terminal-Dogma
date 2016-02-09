main.controller('cartController',['$rootScope','utilities','inform',function($rootScope,utilities,inform){
    var self = this;
    
    self.addCourse = function (courseID, price){
    	inform.add("Hai aggiunto " + courseID + " al carrello.");
    	$rootScope.cart.push({courseID: courseID, price: price});
    	console.log("Corsi nel carrello: ", $rootScope.cart);
    }
    
    self.getCoursesToPay = function()
    {
    	return $rootScope.cart;
    }
    
    self.pay = function(){
    	console.log($rootScope.cart);
    }
    
    self.getTotalPrice = function(){
    	var total = 0;
    	
    	for(var i=0; i<$rootScope.cart.length; i++)
    		total += parseInt($rootScope.cart[i].price);
    	
    	return total;
    }
}]);