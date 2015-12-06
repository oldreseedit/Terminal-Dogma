main.controller('avatarController',['$http','$scope','$uibModal','$route',function($http,$scope,$uibModal,$route){
	var self = this;
    
    self.changeAvatar = function(username,avatar)
    {
    	if($route.current.locals.username === $scope.username || $scope.admin)
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