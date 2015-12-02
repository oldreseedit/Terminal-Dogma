main.controller('profileController',['utilities','$scope','$http','$routeParams','$route','$timeout','$cookies',function(utilities,$scope,$http,$routeParams,$route,$timeout,$cookies){
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
    self.tempCourses = $route.current.locals.courses;
    self.courses = [];
   for(var i=0; i<self.tempCourses.length; i++)
	{
	   	self.courses[i] = {};
	   	self.courses[i].courseID = self.tempCourses[i];
    	self.courses[i].name = self.tempCourses[i].charAt(0).toUpperCase() + self.tempCourses[i].slice(1);
    	self.courses[i].name = self.courses[i].name.split(/(?=[A-Z](?=[a-z]))/).join(" ");
	}
    self.lastAchievement = $route.current.locals.lastAchievement;
    self.nextReward = $route.current.locals.nextReward;
    console.log(self.lastAchievement);
    console.log(self.expInfo);
    
    var notificationIDs = [];
    angular.forEach($scope.notifications,function(i)
	    {
    		notificationIDs.push(i.notificationID);
	    }		
    );
    $timeout(function()
    	{
    		$http.post('notifications/update_seen',{notificationIDs : notificationIDs}).then(
		    		function(response)
		    		{
		    			if(!response.data.error) $scope.getUnseenNotifications();
		    		},
		    		function(error)
		    		{
		    			console.log(error);
		    		}
		    );
    	},2000
    );
    
    self.isSeen = function(notification)
    {
    	for(var i=0; i<$scope.notifications.length; i++)
    	{
    		if($scope.notifications[i].notificationID === notification.notificationID) return false;
    	}
    	return true;
    };
    
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
    
    $scope.$watch(
    		function()
    		{
    			if($('.profile-name-level-xp')) return $('.profile-name-level-xp').height(); 
    		},
    		function(newValue, oldValue)
    		{
    			if(newValue > 0)
    			{
    				$('.profile-level-symbol').height(newValue);
    			}
    		}
    )
    
}]);