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
            	}, 250
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
   
    // Loading Positions
    

    self.setStaticProperties = function(item)
    {	
		switch(item.id)
		{
			case 'profileSummary':
				item.title = 'Sommario';
				item.bgColour = 'bg-light-olive';
            	item.templateUrl = 'templates/profile-summary.php';
				break;
			case 'profileNotifications':
				item.title = 'Notifiche';
				item.bgColour = 'bg-light-lawn';
            	item.templateUrl = 'templates/profile-notifications.php';
            	item.minSizeY = 2;
				break;
			case 'profileAchievements':
				item.title = 'Achievements';
				item.bgColour = 'bg-light-green';
            	item.templateUrl = 'templates/profile-achievements.php';
				break;
			case 'profileRewards':
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
		$http.post('profile/update_block_positions',{username: self.username, panelID: item.id, measures : item.measures}).then(
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
    
    $scope.registerAllMeasures = function(grid)
    {
//    	console.log(grid);
    	angular.forEach(grid,function(items){
    		angular.forEach(items,function(item){
    			var data = {};
				data.measures = JSON.stringify(item.toJSON());
//				console.log(item.$element.scope());
				data.id = item.$element.scope().id;
				$scope.registerMeasures(data);
    		});
    	});
    }
    
    $http.post('profile/load_block_positions',{username : self.username}).then(
    		function(response)
    		{    			
    			if(!response.data.error)
    			{
//    				console.log(response.data);
    				var items = [];
    				angular.forEach(response.data.panelMeasures, function(m)
    				{
    					var item = JSON.parse(m.panel_measure);
    					item.id = m.panelID;
    					items.push(item);
    				});
    				
    				$timeout(function(){
        				$scope.$broadcast('measuresLoaded');    				
    				});	    
    			}
    			else
    			{
    				 var items = [
						{
							id:"profileSummary",
							sizeX : 6,
							sizeY: 1,
							col: 0,
							row: 0
					  },
					  {
							id:"profileNotifications",
							sizeX : 6,
							sizeY: 1,
							col: 6,
							row: 0
					  },
					  {
							id:"profileAchievements",
							sizeX : 6,
							sizeY: 1,
							col: 0,
							row: 10
					  },
					  {
							id:"profileRewards",
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
//				$timeout(function(){
//					$scope.$broadcast('gridsterItemsLoaded');
//				});
    		},
    		function(error)
    		{
    			console.log(error);
    		}
    );

    // Loading Avatar 
    
    $http.post('avatars/get_avatar',{username: self.username}).then(
		function(response)
		{
//			console.log('avatar');
			if(response.data.avatar) self.avatar = response.data.avatar;
			else self.avatar = "imgs/leaf.png";
			
			$scope.$on('firstLoad', function(){
            	
            	$scope.$watch(
            		function(){
            			return  $('#profile').find('img')[0].complete;
            		},
            		function(newValue){
            			if(newValue === true) $scope.$broadcast('teacher');
            		}
            		
            	);    		
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
			else if(response.data){
				self.notifications = response.data;
				
				$scope.$on('firstLoad', function(){ $scope.$broadcast('notifications');} );
			}
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
			    
			    $scope.$on('firstLoad', function(){
			    	$scope.$broadcast('achievements');
			    	$scope.$broadcast('rewards');
			    });
			    
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
    
    $http.post('payment_interface/get_courses_with_info',{username: self.username}).then(
		function(response)
		{
			if(response.data.error) inform.add(response.data.description,{type:'danger'});
			else if(response.data)
			{
//				console.log(response.data);
//				self.tempCourses = response.data;
				self.courses = [];
			    for(var i=0; i<response.data.length; i++)
				{
				   	self.courses[i] = {};
				   	self.courses[i].courseID = response.data[i].courseID;
				   	self.courses[i].name = response.data[i].name;
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
    
    $scope.$watchCollection(
   		 function(){
   			 return [self.avatar,self.lastAchievement,self.nextReward,self.expInfo, self.courses];
   		 },
   		 function(newValues)
   		 {
   			 var check = true;
   			 angular.forEach(newValues,function(value){
   				 if(value === undefined) check = false;
   			 });
   			 if(check) 
   				 $scope.$on('firstLoad', function(){
   					$timeout(function(){ $scope.$broadcast('summary'); });
   				});
   		 },
   		 true
   );
    
}]);