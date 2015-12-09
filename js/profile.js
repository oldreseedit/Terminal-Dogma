main.controller('profileController',['$scope','$http','$routeParams','$route','$timeout',function($scope,$http,$routeParams,$route,$timeout){
    var self = this;
    
    self.username = $routeParams.userID;
    $route.current.locals.username = self.username; // For modal and GridsterResizer
    self.avatar = $route.current.locals.avatar;
    self.xpBarTypes = function(){        
        return 'success';
    };
    self.notifications = $route.current.locals.notifications;
    self.achievementsAndRewards = $route.current.locals.achievementsAndRewards;
    self.expInfo = $route.current.locals.expInfo;
    self.tempRewards = self.achievementsAndRewards.filter(function(element){if(element.type==='REWARD') return element});
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
    self.lastAchievement = $route.current.locals.lastAchievement ? $route.current.locals.lastAchievement.description : $route.current.locals.lastAchievement;
    self.nextReward = $route.current.locals.nextReward;
    
    var lastRewardIndex= 0;
    for(i=0; i < self.tempRewards.length; i++)
    {
    	if(self.tempRewards[i].username) lastRewardIndex++;
    }
    self.rewards = [];
    for(i=0; i < self.tempRewards.length; i++)
    {
    	if(i<=lastRewardIndex+2) self.rewards.push(self.tempRewards[i]);
    }
    
    self.isMyProfile = function()
    {
    	return (self.username === $scope.username || $scope.admin );
    }
    
    self.isDefaultAvatar = function()
    {
    	return self.avatar === 'imgs/leaf.png';
    };    
    
    var notificationIDs = [];
    angular.forEach($scope.notifications,function(i)
	    {
			notificationIDs.push(i.notificationID);
	    }
    );
    
    self.seeNotification = function(notification)
    {
        $timeout(function()
            	{
            		$http.post('notifications/update',{notificationID : notification.notificationID, seen : true}).then(
        		    		function(response)
        		    		{
//        		    			console.log(response);
        		    			if(!response.data.error) $scope.getUnseenNotifications();
        		    		},
        		    		function(error)
        		    		{
        		    			console.log(error);
        		    		}
        		    );
            	},250
            );    	
    };
    
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
		$http.post('profile/update_block_positions',{username: self.username, blockPositions: JSON.stringify($scope.gridsterItems)}).then(
    			function(response)
    			{
//        				console.log('update_block_positions: ',response);
    			},
    			function(error)
    			{
    				console.log(error);
    			}
    	);  
    };

    $scope.gridsterItems = $route.current.locals.blockPositions;
    if(!$scope.gridsterItems)
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
    else // If measures are loaded
    {
    	$scope.measuresLoaded = true;
    }
    
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
    
    $scope.changeAvatar = function(URI)
    {
    	self.avatar = URI;
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
    );
    
    $scope.$watch(
    		function()
    		{
    			return self.notifications;
    		},
    		function(newValue)
    		{
//    			console.log(newValue);
    			var indexOfNotifications;
    			if(newValue !== undefined && newValue !== null)
    			{
    				for(var i=0; i< $scope.gridsterItems.length; i++)
    				{
    					if($scope.gridsterItems[i].title === 'Notifiche') indexOfNotifications = i;
    				}
    				$scope.gridsterItems[indexOfNotifications].minHeight = 2;
    			}
    		}
    );
    
}]);