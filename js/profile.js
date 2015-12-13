main.controller('profileController',['$scope','$http','$routeParams','$route','$timeout', 'inform',function($scope,$http,$routeParams,$route,$timeout,inform){
    var self = this;
    
    self.username = $routeParams.userID;
    $route.current.locals.username = self.username; // For modal and GridsterResizer
    
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
        				console.log('update_block_positions: ',response);
    			},
    			function(error)
    			{
    				console.log(error);
    			}
    	);  
    };
    
    self.customItemMap = {
        sizeX: 'item.measures.width',
        sizeY: 'item.measures.height',
        row: 'item.measures.position.y',
        col: 'item.measures.position.x',
        minSizeX: 'item.measures.minWidth',
        minSizeY: 'item.measures.minHeight'
    };
    
    self.getTitleOfNotification = function(notification)
    {
    	var title = notification.courseID || 'reSeed';
    	return title;
    };
    
    

    // Loading Avatar 
    
    $http.post('avatars/get_avatar',{username: self.username}).then(
		function(response)
		{
//			console.log('avatar');
			if(response.data.avatar) self.avatar = response.data.avatar;
			else self.avatar = "imgs/leaf.png";
		},
		function(error)
		{
			console.log(error);
			return "imgs/leaf.png";
		}
	);
    
    // Loading Positions
    
    $http.post('profile/load_block_positions',{username: self.username}).then(
    		function(response)
    		{
//    			console.log('loadBlockPositions')
//    			if(response.data.error) inform.add(response.data.description,{type:'danger'});
//    			else if(response.data) $scope.gridsterItems = JSON.parse(response.data.blockPositions);
    			
    			if(!response.data.error) $scope.gridsterItems = JSON.parse(response.data.panelMeasures);
    			
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
    			
    		},
    		function(error)
    		{
    			console.log(error);
    		}
	);
    
    // Loading notifications
    
    $http.post('notifications/get_user_notifications',{username: self.username}).then(
		function(response)
		{
//			console.log('notifications');
			if(response.data.error) inform.add(response.data.description,{type:'danger'});
			else if(response.data) self.notifications = response.data;
		},
		function(error)
		{
			console.log(error);
		}
	);
    
    // Loading A&R
    
    $http.post('achievements_and_rewards/get_achievements_and_rewards',{username: self.username}).then(
		function(response)
		{
//			console.log('achievementsAndRewards');
			if(response.data.error) inform.add(response.data.description,{type:'danger'});
			else if(response.data)
			{
				self.achievementsAndRewards = response.data;
			    self.tempRewards = self.achievementsAndRewards.filter(function(element){if(element.type==='REWARD') return element});
//			    console.log(self.tempRewards);
			    var lastRewardIndex= 0;
			    for(i=0; i < self.tempRewards.length; i++)
			    {
			    	if(self.tempRewards[i].username) lastRewardIndex++;
			    }
			    self.rewards = [];
			    for(i=0; i < self.tempRewards.length; i++)
			    {
			    	if(i==lastRewardIndex+1) self.nextReward = self.tempRewards[i].description;
			    	if(i<=lastRewardIndex+2) self.rewards.push(self.tempRewards[i]);
			    }			    

			    self.achievements = self.achievementsAndRewards.filter(function(element){if(element.type==='ACHIEVEMENT') return element});
//			    console.log(self.achievements);
			    var lastAchievementIndex= 0;
			    var last;
			    for(i=0; i < self.achievements.length; i++)
			    {
			    	if(self.achievements[i].username)
			    	{
				    	var thisTime = moment(self.achievements[i].publishingTimestamp);
				    	if(!last || last.isBefore(thisTime))
				    	{
				    		last = thisTime;
				    		lastAchievementIndex = i;
				    	}
			    	}
			    }
			    self.lastAchievement = self.achievements[lastAchievementIndex].description;
			    
			}
		},
		function(error)
		{
			console.log(error);
		}
	);
    
    // Loading Exp Info
    
    self.expInfo = {partialExperience: 0};
    $http.post('users/get_exp_info',{username: self.username}).then(
		function(response)
		{
//			console.log('expInfo');
			if(response.data.error) inform.add(response.data.description,{type:'danger'});
			else if(response.data) self.expInfo = response.data.expInfo;
		},
		function(error)
		{
			console.log(error);
		}
	);
    
    // Loading Courses
    
    $http.post('payment_interface/get_courses',{username: self.username}).then(
		function(response)
		{
//			console.log('courses');
			if(response.data.error) inform.add(response.data.description,{type:'danger'});
			else if(response.data)
			{
				self.tempCourses = response.data;
				self.courses = [];
			    for(var i=0; i<self.tempCourses.length; i++)
				{
				   	self.courses[i] = {};
				   	self.courses[i].courseID = self.tempCourses[i];
			    	self.courses[i].name = self.tempCourses[i].charAt(0).toUpperCase() + self.tempCourses[i].slice(1);
			    	self.courses[i].name = self.courses[i].name.split(/(?=[A-Z](?=[a-z]))/).join(" ");
				}
			}
		},
		function(error)
		{
			console.log(error);
		}
	);
    
    // Watchers
    
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
    				if($scope.gridsterItems)
    				{
        				for(var i=0; i< $scope.gridsterItems.length; i++)
        				{
        					if($scope.gridsterItems[i].title === 'Notifiche') indexOfNotifications = i;
        				}
        				$scope.gridsterItems[indexOfNotifications].minHeight = 2;    					
    				}
    			}
    		}
    );
    
}]);