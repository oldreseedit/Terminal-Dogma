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

main.controller('avatarFormController',['$scope','$http','$timeout','$cookies','$window','upload','inform','$route','items','$server',function($scope,$http,$timeout,$cookies,$window,upload,inform,$route,items,$server){
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
			$scope.$evalAsync( function(){
				self.fr.readAsDataURL(file[0]);
				self.loading = true;
			});
			
			self.fr.onloadend = function(){
				self.loading = false;
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
					url: 'avatars/load_temporary_avatar',
					method: 'POST',
					data : {
						file: angular.element('[type="file"]'),
						username : self.username
					}
				}).then(
						function (response) {
							if(response.data.error) inform.add(response.data.description, {type: 'danger'});
							else
							{
								var avatarUri = response.data.description;
								
								$server.post('avatars/load_avatar',{username: self.username, avatarUri: avatarUri}).then(
										function(response)
										{
											inform.add('Avatar caricato con successo!');
											$scope.$close(response.data.description);
										}
								);
							}
						},
						function (error) {
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
				$server.post('avatars/load_avatar',{username: self.username, avatarUri: self.temp}).then(
						function(response)
						{
							for(var i=0; i<response.data.length; i++)
							{
								if(!response.data[i].error)
								{
									if(response.data[i].finalAvatarURI)
									{
										inform.add('Avatar caricato con successo!');
										$scope.$close(response.data[i].finalAvatarURI);
									}
									else inform.add(response.data[i].description);
								}
								else
								{
									inform.add(response.data[i].description, {type: 'warning'});
								}
							}
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
			self.tempUriAjax = $server.post('avatars/load_temporary_avatar',
					{
						username: self.username,
						avatarUri: URI
					}
			).then
			(
					function(response)
					{
						// Per visualizzare un msg di errore quando la risposta del server che contiene l'immagine
						// è diversa da 200. Ad esempio se si inserisce il seguente URI: http://www.missbenessere.net/wp-content/uploads/2015/09/minions_film_recensione.jpg
						if(response.data.error)
						{
							inform.add(response.data.description,{type: 'warning'});
						}
						else
						{
							self.temp = response.data.description;
							self.readyToSubmit = true;
							self.loading = false;
						}
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