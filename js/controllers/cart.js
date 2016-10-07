main.controller('cartController',['$rootScope','utilities','inform','cartService','$server','$cookies','$location',function($rootScope,utilities,inform,cartService,$server,$cookies,$location){
    var self = this;

    self.paymentOptions = {
    		customSeedon: {
	        	 description: '',
	        	 longDescription: '',
	        	 seedonID: -1,
	        	 code: ''
    		},
    		seedon: [
    		         {
    		        	 description: 'Usa questa opzione se non vuoi ancora usare i tuoi seedon.',
    		        	 longDescription: 'Non voglio usare seedon',
    		        	 seedonID: -1,
    		        	 code: ''
    		         }
    		         ],
    		paymentCycleOptions: [
								{
									  value: '',
									  label: '',
									  description: ''
								},
  				                {
  			                	   value: 'monthly',
  					        	   label: 'In 3 rate mensili',
  					        	   description: 'Scegliendo questa opzione decidi di pagare di mese in mese.'
  				                },
  				                {
  			                	   value: 'oneShot',
  					        	   label: 'One shot',
  					        	   description: 'Scegliendo questa opzione decidi di pagare in una volta sola.'
  				                }
  					               ],
			paymentMediaOptions: [
			          {
						  value: '',
						  label: '',
						  description: ''
					  },
			          {
			        	  value: 'creditCard',
			        	  label: 'Pagamento online',
			        	  description: 'Scegliendo questa opzione decidi di pagare online con una carta di credito o il tuo conto PayPal.'
			          },
			          {
			        	  value: 'wireTransfer',
			        	  label: 'Bonifico',
			        	  description: 'Scegliendo questa opzione decidi di pagare attraverso un bonifico.'
			          },
			          {
			        	  value: 'cash',
			        	  label: 'Contanti',
			        	  description: 'Scegliendo questa opzione decidi di pagare in contanti alla prima lezione.'
			          }
			          ]	
    };
    
    self.getCart = function()
    {
    	return cartService.getCart();
    }
    
    self.getCoursesToPay = function()
    {
    	return cartService.getCoursesToPay();
    }
    
    self.prepay = function(){
  	  cartService.squeeze();
  	  $location.path("/pre-pay");
  	  //window.location = "/pre-pay";
    }

    self.getCourseIcon = function(item)
    {
    	var icon='noCourse';
    	angular.forEach(self.courses, function(course)
		{
    		if(course.courseID === item.courseID)
    		{
    			icon = course.icon; 
    		}
		});
    	return icon;
    }
    
    self.pay = function(){
    	  self.paypalAjax = cartService.pay();
    }
    
    self.getTotalPrice = function(){
    	return cartService.getTotalPrice();
    }
    
    self.getFinalPrice = function(){
    	return cartService.getFinalPrice();
    }
    
    self.remove = function(item){
    	inform.add("Hai rimosso " + item.courseName + " dal carrello.");
    	return cartService.remove(item);
    }
    
    self.emptyCart = function(){
    	cartService.emptyCart();
    }
    
    self.toggleSimulation = function(item){
    	cartService.toggleSimulation(item);
    }
    
    self.toggleCourse = function(item){
    	cartService.toggleCourse(item);
    }
    
    self.applySeedon = function(seedonIdx){
    	var seedon = self.paymentOptions.seedon[seedonIdx];
    	if(!seedon)
    	{
    		self.getCart().options.seedonDiscount = 0;
    	}
    	else if(seedon.tag === "DISCOUNT")
    	{
    		self.getCart().options.seedonDiscount = parseFloat(seedon.data);
    	}
    	
    	self.getCart().save();
    }
    
    self.applyCustomSeedon = function(customSeedon){
    	$server.post('seedon/get_seedon_by_name', {"seedon": customSeedon.seedon}).then(
    	    	function(response){
    	    		console.log(response);
    	    		inform.add(response.data.description);
    	    		var seedon = response.data.seedon;
    	    		self.paymentOptions.customSeedon = seedon;
    	    		self.paymentOptions.customSeedon.longDescription = seedon.description + ": " + (100*seedon.data) + "%";
    	    		console.log(self.paymentOptions.customSeedon);
    	    		
    	    		inform.add("Sconto del " + (100 * parseFloat(seedon.data)) + "% applicato.");
    	    		
    	    		self.getCart().options.seedonDiscount = parseFloat(seedon.data);
    	    		self.getCart().options.customSeedon = self.paymentOptions.customSeedon;
    	    		self.getCart().options.seedOnChosen = self.paymentOptions.customSeedon.seedonID;
    	    		self.getCart().save();
    	    	},
    	    	function(response){
    	    		console.log(response);
    	    	});
    }
    
    self.applyPaymentMedia = function(){self.getCart().save();}
    self.applyPaymentCycle = function(){self.getCart().save();}
    
    self.coursesAjax = $server.post('courses/get_all').then(
    	function(response){
    		self.courses = response.data;
    	}
    );
    
    $server.post('seedon/get_seedon_not_used',{username : $cookies.get('username')}).then(
    		function(response)
    		{
    			for(var i=0; i<response.data.length; i++)
    			{
    				var seedon = response.data[i];
    				seedon.longDescription = seedon.description + ": " + (100*seedon.data) + "%";
    				self.paymentOptions.seedon.push(seedon);
    			}
    		}
        );
    
}]);