main.controller('activityController',['utilities','$scope','$http','$routeParams','uiCalendarConfig','$timeout','$route','$cookies',function(utilities,$scope,$http,$routeParams,uiCalendarConfig,$timeout,$route,$cookies){
    var self = this;
    
    /* CONFIG */
    
    self.username = $cookies.get('username');
    $route.current.locals.username = self.username; // For modal and GridsterResizer
    
    self.activityName = $route.current.locals.activityDescription.name;
    
    self.activityID = $routeParams.activityID;
    self.activityDescription = $route.current.locals.activityDescription;
    
    $scope.gridsterOpts = {
    	resizable : {
    		enabled : false
    	},
    	draggable : {
    		enabled: false
    	}
    };
    
    /* METHODS */
    
    /* PROPER OBJECTS AND METHODS */
    
    $scope.registerMeasures = function()
    {
		$http.post('activity/update_block_positions',{username: self.username, activityID: self.activityID, blockPositions: JSON.stringify($scope.gridsterItems)}).then(
    			function(response)
    			{
        			console.log(response);
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
    				$scope.gridsterItems = JSON.parse(JSON.parse(response.data));
    				
    				$scope.measuresLoaded = true;
    			}
    			else
    			{
    				 $scope.gridsterItems = [
	                     {
	                         title: self.activityName,
	                         bgColour: 'bg-light-olive',
	                         templateUrl: 'templates/activity-description.php',
	                         measures: {
	                             width: 8,
	                             height: 1,
	                             position: {
	                                 x : 0,
	                                 y : 0
	                             }
	                         }
	                     },
	                 ];
    			}
    		},
    		function(error)
    		{
    			console.log(error);
    		}
    );
    
    self.customItemMap = {
        sizeX: 'item.measures.width',
        sizeY: 'item.measures.height',
        row: 'item.measures.position.y',
        col: 'item.measures.position.x',
        minSizeX: 'item.measures.minWidth',
        minSizeY: 'item.measures.minHeight'
    };
    
    /* MAIN */
    
}]);