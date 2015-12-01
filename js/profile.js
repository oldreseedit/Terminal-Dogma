main.controller('profileController',['utilities','$scope','$http','$routeParams','$route',function(utilities,$scope,$http,$routeParams,$route){
    var self = this;
    
    self.username = $routeParams.userID;
    self.xpBarTypes = function(){        
        return 'success';
    };
    self.notifications = $route.current.locals.notifications;
    self.achievementsAndRewards = $route.current.locals.achievementsAndRewards;
    self.expInfo = $route.current.locals.expInfo;
    self.rewards = self.achievementsAndRewards.filter(function(element){if(element.type==='REWARD') return element});
    self.achievements = self.achievementsAndRewards.filter(function(element){if(element.type==='ACHIEVEMENT') return element});
    
    console.log(self.expInfo);
    
    $scope.registerMeasures = function()
    {
    	$http.post('profile/save_block_positions',{username: self.username, blockPositions: JSON.stringify($scope.gridsterItems)}).then(
    			function(response)
    			{
//    				console.log('save_block_positions: ',response);
    			},
    			function(error)
    			{
    				console.log(error);
    			}
    	);
    }
    
    $http.post('profile/load_block_positions',{username: self.username}).then(
    		function(response)
    		{
//    			console.log('load_block_positions: ', response);
    			
    			if(response.data)
    			{
    				$scope.gridsterItems = JSON.parse(JSON.parse(response.data));
    				
    				$scope.measuresLoaded = true;
    			}
    			else
    			{
	    			$scope.gridsterItems = self.items || [
		              {
		              	title: 'Sommario',
		                  bgColour: 'bg-light-olive',
		                  templateUrl: 'templates/profile-summary.php',
		                  measures: {
		                      width: 6,
		                      height: 1,
		                      position: {
		                          x : 0,
		                          y : 0
		                      }
		                  }
		              },
		              {
		              	title: 'Notifiche',
		                  bgColour: 'bg-light-lawn',
		                  templateUrl: 'templates/profile-notifications.php',
		                  measures: {
		                      width: 6,
		                      height: 1,
		                      position: {
		                          x : 7,
		                          y : 0
		                      }
		                  }
		              },
		              {
		              	title: 'Achievements',
		                  bgColour: 'bg-light-green',
		                  templateUrl: 'templates/profile-achievements.php',
		                  measures: {
		                      width: 6,
		                      height: 1,
		                      position: {
		                          x : 0,
		                          y : 7
		                      }
		                  }
		              },
		              {
		              	title: 'Rewards',
		                  bgColour: 'bg-light-leaf',
		                  templateUrl: 'templates/profile-rewards.php',
		                  measures: {
		                      width: 6,
		                      height: 1,
		                      position: {
		                          x : 7,
		                          y : 7
		                      }
		                  }
		              }
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
    
    /* METHODS */
    
    self.getTitleOfNotification = function(notification)
    {
    	var title = notification.courseID || 'reSeed';
    	return title;
    };
    
    
    
}]);