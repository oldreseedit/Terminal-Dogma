main.controller('profileController',['$scope','$server','$routeParams','$route','$timeout', 'inform','$server',function($scope,$server,$routeParams,$route,$timeout,inform,$server){
    var self = this;
    
    self.username = $routeParams.userID;
    $route.current.locals.username = self.username; // For modal and GridsterResizer
    
    var scrollbarsCreated = false;
    
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
        $timeout(
    		function(){
        		$server.post('notifications/update',{notificationID : notification.notificationID, seen : true}).then(
    		    		function(response)
    		    		{
    		    			if(!response.data.error) $scope.getUnseenNotifications();
    		    		}
    		    );
        	}, 250);    	
    };
    
    self.isSeen = function(notification)
    {
    	for(var i=0; i<$scope.notifications.length; i++)
    	{
    		if($scope.notifications[i].notificationID === notification.notificationID) return false;
    	}
    	return true;
    };
    
    self.items = [
          {
        	  id : 'profileSummary',
        	  title: 'Sommario',
        	  bgColour: 'bg-light-olive',
        	  templateUrl : 'templates/profile-summary.php',
        	  width: 50
          },
          {
        	  id : 'profileNotifications',
        	  title: 'Notifiche',
        	  bgColour: 'bg-light-lawn',
        	  templateUrl : 'templates/profile-notifications.php',
        	  width: 49,
        	  offset: 1
          },
          {
        	  id : 'profileAchievements',
        	  title: 'Achievements',
        	  bgColour: 'bg-light-green',
        	  templateUrl : 'templates/profile-achievements.php',
        	  width: 50
          },
          {
        	  id : 'profileRewards',
        	  title: 'Rewards',
        	  bgColour: 'bg-light-leaf',
        	  templateUrl : 'templates/profile-rewards.php',
        	  width: 49,
        	  offset: 1
          },
          {
        	  id : 'profileHighScores',
        	  title: 'High scores',
        	  bgColour: 'bg-light-water',
        	  templateUrl : 'templates/profile-highscores.php',
        	  width: 49,
        	  offset: 1
          },
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
    
    /* PROPER OBJECTS AND METHODS */

    // Loading Avatar 
    
    self.avatarAjax = $server.post('avatars/get_avatar',{username: self.username},false).then(
		function(response)
		{
			if(response.data.avatar) self.avatar = response.data.avatar;
			else self.avatar = "imgs/leaf.png";
		}
	);
 
    // Loading notifications
    
    self.notificationsAjax = $server.post('notifications/get_user_notifications',{username: self.username}).then(
		function(response)
		{
			self.notifications = response.data;
		}
	);
    
    // Loading A&R
    
    self.achievementsAndRewardsAjax = $server.post('achievements_and_rewards/get_achievements_and_rewards',{username: self.username},false).then(
		function(response)
		{
			self.achievementsAndRewards = response.data;
		    self.rewards = self.achievementsAndRewards.filter(function(element){if(element.type==='REWARD') return element});
//			    console.log(self.tempRewards);
		    
		    var lastRewardIndex = -1;
		    while(lastRewardIndex+1 < self.rewards.length && self.rewards[lastRewardIndex+1].username) lastRewardIndex++;
		    if(lastRewardIndex+1 < self.rewards.length) self.nextReward = self.rewards[lastRewardIndex+1].description;
		    
		    self.achievements = self.achievementsAndRewards.filter(function(element){if(element.type==='ACHIEVEMENT') return element});
//			    console.log(self.achievements);
		    var last;
		    for(i=0; i < self.achievements.length; i++)
		    	if(self.achievements[i].username)
			    	if(!last || moment(last.publishingTimestamp).isBefore(moment(self.achievements[i].publishingTimestamp)))
			    		last = self.achievements[i];
		    if(last) self.lastAchievement = last.description;
		}
	);
    
    // Loading Exp Info
    
    self.expInfo = {partialExperience: 0};
    self.expInfoAjax = $server.post('users/get_exp_info',{username: self.username},false).then(
		function(response)
		{
			self.expInfo = response.data.expInfo;
		}
	);
    
    // Loading Courses
    
    self.coursesAjax = $server.post('payment_interface/get_courses_with_info',{username: self.username},false).then(
		function(response)
		{
			self.courses = [];
		    for(var i=0; i<response.data.length; i++)
			{
			   	self.courses[i] = {};
			   	self.courses[i].courseID = response.data[i].courseID;
			   	self.courses[i].name = response.data[i].name;
			}
		}
	);
    
    self.expAjax = $server.post('users/get_all_users_exp', null, false).then(
    		function(response)
    		{
    			self.highscores = [];
    		    for(var i=0; i<response.data.users.length; i++)
    			{
    			   	self.highscores[i] = {};
    			   	self.highscores[i].username = response.data.users[i].userID;
    			   	self.highscores[i].avatar = response.data.users[i].profilePicture;
    			   	if(self.highscores[i].avatar === "") self.highscores[i].avatar = '/imgs/leaf.png';
    			   	self.highscores[i].level = response.data.users[i].level;
    			   	self.highscores[i].exp = response.data.users[i].currentExp;
    			}
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
    		function()
    		{
    			var ajaxes = [self.coursesAjax, self.notificationsAjax, self.achievementsAndRewardsAjax, self.expInfoAjax, self.avatarAjax, self.expAjax];
    			
    			var states = [];
    			var allDefined = true;
    			for(var i=0; i<ajaxes.length;i++)
    			{
    				if(!ajaxes[i].$$state) allDefined = false;
    				else states[i] = ajaxes[i].$$state.status;
    			}
    			return states;
    		},
    		function(newValues){
    			
    			var allReady = true;
    			
    			for(var i = 0; i < newValues.length; i++)
    			{
    				if(!newValues[i]) allReady=false;
    			}
    			
    			if(allReady)
    			{
    				$timeout(function(){
    					
    					$scope.$watchCollection(
    							function(){
    				    			if($('.no-gridster-item').length > 0)
    				    			{
    				    				var items = $('.no-gridster-item');
    				    				var heights = [];
    				    				items.each(function(){
    				    					heights.push($(this).height());
    				    				});
    				    				return heights;
    				    			}
    							},
    							function(){
    		    					
    		    	    			$('.no-gridster-item').each(function(){
    		    	    				$(this).find('.scrollbar-wrapper').height(
    		    	    						$(this).height() - $(this).find('.panel-title').height() - 20
    		    	    				);
    		    	    			});
    		    	    			
    		    	    			var scrollbars = $('.no-gridster-item').find('.scrollbar');
    		    	    			
//    		    	    			if(!scrollbars.perfectScrollbar) scrollbars.perfectScrollbar('update');
    		    	    			
    		    	    			if(!scrollbarsCreated)
    		    					{
    		    						scrollbars.perfectScrollbar({
    		    							suppressScrollX: true,
    		    							useSelectionScroll: true
    		    						});
    		    						scrollbarsCreated = true;
    		    					}
    		    					else
    		    					{
    		    						scrollbars.perfectScrollbar('update');
    		    					}
    								
    							}
    					);	
    				});
    			}
    		}
    );
    
}]);