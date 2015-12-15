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
    

    self.setStaticProperties = function(item)
    {	
		switch(item.id)
		{
			case 'profile-summary':
				item.title = 'Sommario';
				item.bgColour = 'bg-light-olive';
            	item.templateUrl = 'templates/profile-summary.php';
				break;
			case 'profile-notifications':
				item.title = 'Notifiche';
				item.bgColour = 'bg-light-lawn';
            	item.templateUrl = 'templates/profile-notifications.php';
            	item.minSizeY = 2;
				break;
			case 'profile-achievements':
				item.title = 'Achievements';
				item.bgColour = 'bg-light-green';
            	item.templateUrl = 'templates/profile-achievements.php';
				break;
			case 'profile-rewards':
				item.title = 'Rewards';
				item.bgColour = 'bg-light-leaf';
            	item.templateUrl = 'templates/profile-rewards.php';
				break;
		}
    }
    
    /* PROPER OBJECTS AND METHODS */
    
    $scope.gridsterItems = [];
    
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
    
    $http.post('profile/load_block_positions',{username : self.username, courseID : self.courseID}).then(
    		function(response)
    		{    			
    			if(!response.data.error)
    			{
    				console.log(response.data);
    				var items = response.data.panelMeasures;
    				angular.forEach(items, function(m)
    				{
        				m.block_positions = JSON.parse(m.block_positions);
    				});
    			}
    			else
    			{
    				 var items = [
						{
							id:"profile-summary",
							sizeX : 6,
							sizeY: 1,
							col: 0,
							row: 0
					  },
					  {
							id:"profile-notifications",
							sizeX : 6,
							sizeY: 1,
							col: 6,
							row: 0
					  },
					  {
							id:"profile-achievements",
							sizeX : 6,
							sizeY: 1,
							col: 0,
							row: 10
					  },
					  {
							id:"profile-rewards",
							sizeX : 6,
							sizeY: 1,
							col: 6,
							row: 10
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
    
}]);