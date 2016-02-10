main.factory('cartService',['inform', function(inform){
	var cart = [
                {courseID: 'java', price: "300"},
                {courseID: '3DStudioMax', price: "450"},
                {courseID: 'mobileApp', price: "250"}
               ];
	
	cart.addCourse = function (courseID, price){
    	inform.add("Hai aggiunto " + courseID + " al carrello.");
    	cart.push({courseID: courseID, price: price});
    	console.log("Corsi nel carrello: ", cart);
    }
    
	cart.getCoursesToPay = function()
    {
    	return cart;
    }
    
	cart.pay = function(){
    	console.log(cart);
    }
    
	cart.getTotalPrice = function(){
    	var total = 0;
    	
    	for(var i=0; i<cart.length; i++)
    		total += parseInt(cart[i].price);
    	
    	return total;
    }
	
	return cart;
}]);