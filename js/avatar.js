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
            },function(reason){
                
            });
    	}
    	else inform.add('Non hai il permesso di modificare l\'avatar di un altro utente.',{type:'warning'});
    	
    }
    
}]);

/* AVATAR FORM CONTROLLER */

main.controller('avatarFormController',['$scope','$http','$timeout','$cookies','$window','upload','inform','$route','items',function($scope,$http,$timeout,$cookies,$window,upload,inform,$route,items){
	var self = this;
	
	self.avatarForm = {};
	self.username = items.username;
	self.temp = items.avatar;

    self.isDefaultAvatar = function()
    {
//    	console.log(self.temp);
    	return self.temp === 'imgs/leaf.png';
    };    
    
	self.uploadTempAvatar = function(file)
	{			
			upload({
				url: 'avatars/load_temporary_avatar',
				method: 'POST',
				data : {
					file : angular.element('[type="file"]'),
					username : self.username
				}
			}).then(
					function (response) {
//						console.log(response.data.description);
//						console.log(response);
						
						if(response.data.error) inform.add(response.data.description, {type: 'danger'});
						else self.temp = response.data.description;
						
						// TODO: create a new input and set file input with opacity=0, then copy all data to the old one 
						
//						$('[type="file"]').val(oldFile);
//						console.log($('[type="file"]').prop('files'));
					},
					function (error) {
						console.log(error); 
					}
			);
	};
	
	self.submit = function()
	{
		if(self.temp)
		{
			$http.post('avatars/load_avatar',{username: self.username, avatar_temp_URI : self.temp}).then(
					function(response)
					{
						
						if(response.data.error) angular.inform(response.data.description, {type: 'danger'});
						else
						{
							inform.add("Nuovo avatar caricato con successo!", {type: 'success'});
							$scope.setAvatar();
							$scope.$close(response.data.description);
						}
					},
					function(error)
					{
						console.log(error);
					}
			)
		}
		else
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
						if(response.data.error) angular.inform(response.data.description, {type: 'danger'});
					},
					function (error)
					{
						console.log(error); 
					}
			);
		}
		
//		$timeout(function(){$window.location.reload();});
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
					if(response.data.error) angular.inform(response.data.description, {type: 'danger'});
					else self.temp = response.data.description;
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
			self.loadTemporaryURI(newValue);
		}
	);
	
}]);