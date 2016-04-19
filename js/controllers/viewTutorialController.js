main.controller('viewTutorialController',['$rootScope','$scope','$server','$routeParams','$route','$timeout', 'inform','$server','$compile','$sce',function($rootScope,$scope,$server,$routeParams,$route,$timeout,inform,$server,$compile,$sce){
    var self = this;
    
    var scrollbarsCreated = false;
    self.tutorialID = $routeParams.tutorialID;
    
    self.tutorialInfoAjax = $server.post('tutorials/get',{tutorialID: self.tutorialID}).then(
    		function(response)
    		{
    			self.tutorial = response.data;
//    			console.log(self.tutorial);
    			
    			self.tutorial.body = JSON.parse(self.tutorial.body);
    			
    			console.log(self.tutorial);
    			
    			$rootScope.title = self.tutorial.title;
    			$rootScope.description = self.tutorial.description;
    			
    			$rootScope.ogTitle = $rootScope.title;
    		    $rootScope.ogDescription = $rootScope.description;
    		}
    );
    
    self.items = [
                  {
                	  id : 'tutorialDescription',
                	  title: 'Descrizione',
                	  templateUrl : 'templates/tutorial/tutorial-description.php',
                	  width: 75
                  },
                  {
                	  id : 'tutorialSeealso',
                	  title: 'Ti piace questo tutorial?',
                	  templateUrl : 'templates/tutorial/tutorial-seealso.php',
                	  width: 24,
                	  offset: 1
                  },
                  {
                	  id : 'tutorialRequirements',
                	  title: 'Ambiente di lavoro',
                	  templateUrl : 'templates/tutorial/tutorial-requirements.php',
                	  width: 100
                  },
//                  {
//                	  id : 'tutorialMain',
//                	  title: 'Tutorial',
//                	  templateUrl : 'templates/tutorial/tutorial-main.php',
//                	  width: 100
//                  },
        	];
            
    self.getItemClass = function(item)
    {
    	return 'col-' + item.width + (item.offset ? ' offset-'+item.offset : '') ;
    };
    
    self.isNewRow = function(index)
    {
    	var sum = 0;
    	for(var i=0; i<index; i++)
    	{
    		sum += self.items[i].width + (self.items[i].offset ? self.items[i].offset : 0);
    	}
    	if(sum%100 === 0) return true;
    	else return false;
    }
}]);