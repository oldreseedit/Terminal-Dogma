main.controller('cartController',['$rootScope','utilities','inform','cartService','$server','$cookies',function($rootScope,utilities,inform,cartService,$server,$cookies){
    var self = this;

    self.paymentOptions = {
    		seedon: [
    		         {
    		        	 description: 'Usa questa opzione se non vuoi ancora usare i tuoi seedon.',
    		        	 longDescription: 'Non voglio usare seedon',
    		        	 seedonID: -1
    		         }
    		         ],
    		paymentCycleOptions: [
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
    
    self.pay = function(){
    	  cartService.pay();
    }
    
    self.getTotalPrice = function(){
    	return cartService.getTotalPrice();
    }
    
    self.getFinalPrice = function(){
    	return cartService.getFinalPrice();
    }
    
    self.remove = function(item){
    	return cartService.remove(item);
    }
    
    self.emptyCart = function(){
    	cartService.emptyCart();
    }
    
    self.toggleSimulation = function(item){
    	cartService.toggle(item);
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
    
    self.applyPaymentMedia = function(){self.getCart().save();}
    self.applyPaymentCycle = function(){self.getCart().save();}
    
    $server.post('seedon/get',{username : $cookies.get('username')}).then(
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