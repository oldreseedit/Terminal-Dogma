main.controller('avatarController',['$http','$scope','$uibModal','$route','inform',function($http,$scope,$uibModal,$route,inform){
	var self = this;
    
    self.changeAvatar = function(username,avatar)
    {
    	if(username === $scope.username || $scope.admin)
    	{
    		var modalInstance = $uibModal.open({
                templateUrl: 'templates/change-avatar-modal.php',
                controller: 'avatarFormController as avatarModal',
                animation: true,
                backdrop: 'static',
                size: 'lg',
                resolve: {
                	items: [function(){
                		var data = {username: username, avatar: avatar};
                		return data;
                	}]
                }
            });
            
            modalInstance.result.then(function(result){
                if($scope.changeAvatar) $scope.changeAvatar(result);
                if(username === $scope.username) $scope.avatarURI = result;
            },function(reason){
                
            });
    	}
    	else inform.add('Non hai il permesso di modificare l\'avatar di un altro utente.',{type:'warning'});
    	
    }
    
}]);

/* AVATAR FORM CONTROLLER */

main.controller('avatarFormController',['$scope','$http','$timeout','$cookies','$window','upload','inform','$route','items',function($scope,$http,$timeout,$cookies,$window,upload,inform,$route,items){
	var self = this;
	
	if(FileReader) self.fr = new FileReader();
	
	self.avatarForm = {};
	self.username = items.username;
	self.temp = items.avatar;

	self.thereIsFileReader = function()
	{
		return FileReader ? true : false;
	}
	
    self.isDefaultAvatar = function()
    {
//    	console.log(self.temp);
    	return self.temp === 'imgs/leaf.png';
    };    
    
    self.getPercent = function()
    {
    	return Math.round(($scope.current/$scope.total)*100) +' %';
    }
    
	self.uploadTempAvatar = function(file)
	{

		if(FileReader)
		{
			$scope.current = 0;
			$scope.loading = true;
			
			$scope.$evalAsync(self.fr.readAsDataURL(file[0]));

			self.fr.onloadstart = function(event)
			{
//				console.log(event);
				$scope.total = event.total;
			};
			
			self.fr.onprogress = function(event){
//				console.log(event);
				$scope.current = event.loaded;
			};
			
			self.fr.onloadend = function(){
				self.temp = self.fr.result;
			};
			
		}
		else // if on Opera Mini or IE<=9 -> generates "no file selected" bug
		{
			self.loading = true;
			upload({
				url: 'avatars/load_temporary_avatar',
				method: 'POST',
				data : {
					file : angular.element('[type="file"]'),
					username : self.username
				}
			}).then(
					function (response) {
						
						if(response.data.error) inform.add(response.data.description, {type: 'danger'});
						else
						{
							self.temp = response.data.description;
							self.readyToSubmit = true;
							self.loading = false;
						}
					},
					function (error) {
						console.log(error); 
					}
			);
		}
	};
	
	self.submit = function()
	{
		if(FileReader && !self.avatarURI)
		{
			var state = self.fr.readyState;
			
			if(state === 2)
			{
				upload({
					url: 'avatars/load_avatar',
					method: 'POST',
					data : {
						file : angular.element('[type="file"]'),
						username: self.username
					}
				}).then(
						function (response)
						{
							if(response.data.error) inform.add(response.data.description, {type: 'danger'});
							else
							{
								inform.add('Avatar caricato con successo!');
								$scope.$close(response.data.description);
							}
						},
						function (error)
						{
							console.log(error); 
						}
				);
			}
			else if(state === 0) inform.add('Non hai caricato alcun file!',{type: 'warning'});
			else if(state === 1) inform.add('Upload ancora in corso!',{type:'warning'});
		}
		else  // if on Opera Mini or IE<=9  OR  with URI
		{
			if(self.readyToSubmit)
			{
				$http.post('avatars/load_avatar',{username: self.username, avatarUri: self.temp}).then(
						function(response)
						{
							if(response.data.error) inform.add(response.data.description, {type: 'danger'});
							else
							{
								inform.add('Avatar caricato con successo!');
								$scope.$close(response.data.description);								
							}
						},
						function(error)
						{
							console.log(error); 
						}
				);
			}
			else
			{
				if(self.loading) inform.add('Upload ancora in corso!',{type:'warning'});
				else inform.add('Non hai caricato alcun file!',{type: 'warning'});
			}
		}
		
	}
	
	self.loadTemporaryURI = function(URI)
	{
			$http.post('avatars/load_temporary_avatar',
					{
						username: self.username,
						avatarUri: URI
					}
			).then
			(
					function(response)
					{
						if(response.data.error) inform.add(response.data.description, {type: 'danger'});
						else
						{
							self.temp = response.data.description;
							self.readyToSubmit = true;
							self.loading = false;
						}
					},
					function(error)
					{
						console.log(error); 
					}
			);		
		
	};
	
	$scope.$watch(
		function()
		{
			return self.avatarURI;
		},
		function(newValue, oldValue)
		{
			if(!newValue) return;
			else
			{
				self.loading = true;
				self.loadTemporaryURI(newValue);
			}
		}
	);
	
}]);