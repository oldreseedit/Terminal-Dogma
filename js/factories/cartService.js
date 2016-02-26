main.factory('cartService',['inform','$cookies','moment','$server', function(inform, $cookies, moment,$server){
	// var cart = [{courseID: 'java', price: '0.01'}];
	var cart = {items: [],
				options:
				{
					discount: 0,
					seedonDiscount: 0,
					seedOnChosen: null,
					paymentCycleChosen: '',
					paymentMediaChosen: '',
				},
				expire:
				{
					num: 120,
					measure: "minutes"
				}
				};
	
	if($cookies.get('cart'))
	{
		cart = JSON.parse($cookies.get('cart'));
		console.log("LOADED CART FROM COOKIES: ", cart);
	}
	
	cart.getCart = function(){return cart;}
	
	cart.addCourse = function (courseData){
		for(var i=0; i<cart.items.length; i++)
			if(cart.items[i].courseID === courseData.courseID)
				return false;
		
    	cart.items.push(courseData);
    	
    	cart.save();
    	
    	return true;
    }
    
	cart.getCoursesToPay = function()
    {
		var num = 0;
		
		for(var i=0; i<cart.items.length; i++)
		{
			if(cart.items[i].paySimulation) num += 1;
			if(cart.items[i].payCourse) num += 1;
		}
		
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
    
    cart.squeeze = function(){
    	cart.items = cart.items.filter(function(item){
    		return item.paySimulation || item.payCourse;
    	});
    	
    	cart.save();    	
    }
    
	cart.pay = function(){
    	return $server.post('paypal/pay', undefined, undefined, undefined, true).then(
				function(response)
				{
					if(!response.data.error)
					{
//						console.log(response);
//						inform.add(response.data.url);
						window.location = response.data.url;
					}
				}
		    );
    }
	
	cart.remove = function(item) {
		cart.items = cart.items.filter(function(cartItem){return cartItem.courseID !== item.courseID});
		cart.save();
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
	
	// Se l'utente è loggato
	if($cookies.get('username'))
		$server.post('users/get_total_discount',{username : $cookies.get('username')}).then(
				function(response)
				{
					cart.options.discount = response.data.discount;
				}
		    );
	
	cart.toggleSimulation = function(item){
		if(!item.courseAlreadyPaid) item.payCourse = true;
		if(!item.simulationAlreadyPaid) item.paySimulation = !item.paySimulation;
		
		cart.save();
	}
	
	cart.toggleCourse = function(item){
		if(!item.courseAlreadyPaid) item.payCourse = !item.payCourse;
		if(!item.simulationAlreadyPaid)
			if(item.paySimulation) item.paySimulation = false;
		
		cart.save();
	}
	
	// Il carrello sarà valido per 30 minuti
	cart.save = function()
	{
		$cookies.put('cart', angular.toJson(cart), {path:'/', expires: moment().add(cart.expire.num, cart.expire.measure).toDate()});
		console.log("CART: ", cart);
	}
	
	return cart;
}]);