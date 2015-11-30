main.controller('avatarController',['$http','$cookies','$uibModal',function($http,$cookies,$uibModal){
	var self = this;
	
	self.getAvatar = function()
    {
    	var avatarURI = $cookies.get('avatarURI');
//    	avatarURI = 'imgs/team/Alessandro.jpg';
    	return avatarURI;
    };
    
    self.changeAvatar = function()
    {
    	var modalInstance = $uibModal.open({
            templateUrl: 'templates/change-avatar-modal.php',
            controller: 'avatarFormController as avatarModal',
            animation: true,
            backdrop: 'static',
            size: 'lg',
            
        });
        
        modalInstance.result.then(function(){
            
        },function(){
            
        });
    }
    
    
}]);