main.factory('cartService',['inform','$cookies','moment','$server', function(inform, $cookies, moment,$server){
	// var cart = [{courseID: 'java', price: '0.01'}];
	var cart = {items: [],
				options:
				{
					discount: 0,
					seedonDiscount: 0,
					seedOnChosen: null,
					paymentCycleChosen: null,
					paymentMediaChosen: null,
				}};
	
	if($cookies.get('cart'))
	{
		cart = JSON.parse($cookies.get('cart'));
		console.log("LOADED CART FROM COOKIES: ", cart);
	}
	
	cart.getCart = function(){return cart;}
	
	cart.addCourse = function (courseData){
		for(var i=0; i<cart.items.length; i++)
			if(cart.items[i].courseID === courseData.courseID) return;
		
    	inform.add('Hai aggiunto ' + courseData.courseName + ' al carrello.<div><a class="leaf" href="/#cart">Vai al carrello!</a></div>', {"html": true});
    	cart.items.push(courseData);
    	
    	cart.save();
    }
    
	cart.getCoursesToPay = function()
    {
		var num = 0;
		
		for(var i=0; i<cart.items.length; i++)
		{
			if(cart.items[i].paySimulation) num += 1;
			if(cart.items[i].payCourse) num += 1;
		}
		
		console.log("NUM", num);
		
		return num;
    }
	
	cart.isInCart = function(courseID)
	{
		return cart.items.filter(function(cartItem){return cartItem.courseID === courseID}).length == 1;
	}
	
	cart.isSimulationInCart = function(courseID) {
		for(var i=0; i<cart.items.length; i++)
			if(cart.items[i].courseID === courseID)
				if(cart.items[i].paySimulation)
					return cart.items[i].paySimulation;
		
		return false;
    }
    
    cart.getItem = function(courseID) {
    	
    	for(var i=0; i<cart.items.length; i++)
			if(cart.items[i].courseID === courseID)
				return cart.items[i];
    	
    	return null;
    }
    
	cart.pay = function(){
//    	console.log(cart);
    	window.location = "index.php/paypal/adaptive_payments/pay_with_options";
		
//		$server.post('paypal/adaptive_payments/pay_with_options', cart.items).then(
//				function(response)
//				{
//					console.log(response);
////					window.location = "index.php/paypal/adaptive_payments/pay_with_options";
//				}
//		    );
    }
	
	cart.remove = function(item) {
		console.log("CART BEFORE REMOVAL: ", cart);
		cart.items = cart.items.filter(function(cartItem){return cartItem.courseID !== item.courseID});
		cart.save();
    	inform.add("Hai rimosso " + item.courseName + " dal carrello.");
    	console.log("CART AFTER REMOVAL: ", cart);
	}
	
	cart.emptyCart = function()
	{
		$cookies.remove('cart');
		cart.items = [];
		cart.options = [];
	}
    
	cart.getTotalPrice = function(){
    	var total = 0;
    	
    	for(var i=0; i<cart.items.length; i++)
    	{
    		if(cart.items[i].payCourse) total += parseFloat(cart.items[i].price);
    		if(cart.items[i].paySimulation && cart.items[i].simulationPrice) total += parseFloat(cart.items[i].simulationPrice);
    	}
    	
    	return total;
    }
	
	cart.getFinalPrice = function(){
    	var total = cart.getTotalPrice();
    	
    	var totalDiscount = 0;
    	if(cart.options.discount > 0) totalDiscount += cart.options.discount;
    	if(cart.options.seedonDiscount > 0)  totalDiscount += cart.options.seedonDiscount;
    	total = total - (total * totalDiscount);
    	
    	if(cart.options.paymentCycleChosen === 'monthly') total /= 3;
    	
    	return total;
    }
	
	if($cookies.get('username'))
	$server.post('users/get_total_discount',{username : $cookies.get('username')}).then(
			function(response)
			{
				cart.options.discount = response.data.discount;
			}
	    );
	
	cart.toggle = function(item){
		item.paySimulation = !item.paySimulation;
		
		cart.save();
		
		console.log("CART: ", cart);
	}
	
	cart.toggleCourse = function(item){
		item.payCourse = !item.payCourse;
		item.paySimulation = item.payCourse;
		
		cart.save();
		
		console.log("CART: ", cart);
	}
	
	cart.save = function()
	{
		$cookies.put('cart', angular.toJson(cart), {path:'/', expires: moment().add(30, 'minutes').toDate()});
	}
	
	return cart;
}]);