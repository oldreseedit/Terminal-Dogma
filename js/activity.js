main.controller('activityController',['utilities','$scope','$http','$routeParams','uiCalendarConfig','$timeout','$route','$cookies',function(utilities,$scope,$http,$routeParams,uiCalendarConfig,$timeout,$route,$cookies){
    var self = this;
    
    /* CONFIG */
    
    self.username = $cookies.get('username');
    $route.current.locals.username = self.username; // For modal and GridsterResizer
    
    self.activityID = $routeParams.activityID;
	self.activityName = self.activityID.split(/([0-9]*[A-Z][a-z]*)/).join(' ');
    self.activityName = self.activityName.charAt(0).toUpperCase() + self.activityName.slice(1);;
    
    $http.post('activities/get',{activityID : self.activityID}).then(function(response) {
        if(response.data.error) inform.add(response.data.description,{type:'danger'});
        else if(response.data)
        {
        	self.activityDescription = response.data;
        }
    },function(error) {
        console.log(error);
    });
    
    $scope.gridsterOpts = {
    	resizable : {
    		enabled : false
    	},
    	draggable : {
    		enabled: false
    	}
    }
    
    $scope.gridsterItems = [];
    
    self.setStaticProperties = function(item)
    {	
		switch(item.id)
		{
			case 'activity-description':
				item.title = 'Sommario';
				item.bgColour = 'bg-light-olive';
            	item.templateUrl = 'templates/activity-description.php';
				break;
		}
    }
    
    
    /* PROPER OBJECTS AND METHODS */

    $scope.registerMeasures = function(item)
    {
		$http.post('course/update_block_positions',{username: self.username, activityID: self.courseID, panelID: item.id, measures : item.measures}).then(
    			function(response)
    			{
//        			console.log(response);
    			},
    			function(error)
    			{
    				console.log(error);
    			}
    	);
    };
    
    $http.post('activity/load_block_positions',{username : self.username, activityID : self.activityID}).then(
    		function(response)
    		{
//    			console.log(response);
    			
    			if(!response.data.error)
    			{    			
        			if(!response.data.error)
        			{
//        				console.log(response.data);
        				var items;
        				angular.forEach(response.data, function(m)
        				{
        					var item = JSON.parse(m.measures);
        					item.id = m.panelID;
        					items.push(item);
        				});
        			}
    			}
    			else
    			{
    				var items = [{
	    					id: 'courseDescription',
	    					sizeX: 8,
	    					sizeY: 1,
	    					row : 0,
	    					col: 0
    					}
    				];
					$timeout(function(){
						$scope.$broadcast('firstLoad');
					});
    			}
				angular.forEach(items,function(item){
					self.setStaticProperties(item);
					
					$scope.gridsterItems.push(item);
				});
    		},
    		function(error)
    		{
    			console.log(error);
    		}
    );
    
    /* MAIN */
    
}]);