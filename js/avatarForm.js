main.controller('avatarFormController',['$scope','$http','$timeout','$cookies','$window','upload',function($scope,$http,$timeout,$cookies,$window,upload){
	var self = this;
	
	self.avatarForm = {};
	
	self.temp = $cookies.get('avatarURI');
	
	self.submit = function()
	{
		var data = self.avatarForm;
        data.file = angular.element('[name="file"]');

//		Qui dovrò chiamare il metodo di titto per caricare l'avatar
        
//        upload({
//          url: 'course_material/modify',
//          method: 'POST',
//          data: data
//        }).then(
//          function (response) {

//				var expireDate = moment.unix(response.data.expire).toDate();
//				$cookies.put('avatarURI',avatarURI,{path: '/',expires: expireDate});
//            console.log(response.data); 
//          },
//          function (response) {
//              console.error(response); 
//          }
//        );
		
//		$window.location.reload();
	}
	
	self.dismiss = function()
	{
//		Qui dovrò chiamare il metodo di titto per eliminare l'avatar
//		$http.post()
//		$cookies.remove('tempAvatar');
//		self.temp = false;
		$scope.$dismiss();
	}
	
	self.uploadTempAvatar = function(file)
	{
//			console.log(file);
//			var oldFile = file[0].name;
			
			upload({
				url: 'avatars/load_temporary_avatar',
				method: 'POST',
				data : {
					file : angular.element('[type="file"]')
				}
			}).then(
					function (response) {
//						console.log(response.data.description);
						if(response.data.error) angular.inform(response.data.description, {type: 'danger'});
						else self.temp = response.data.description;
						
						// TODO: create a new input and set file input with opacity=0, then copy all data to the old one 
						
//						$('[type="file"]').val(oldFile);
//						console.log($('[type="file"]').prop('files'));
					},
					function (response) {
						console.error(response); 
					}
			);
	};
	
	self.submit = function()
	{
		if(self.temp)
		{
			$http.post('avatars/load_avatar',{username: $cookies.get('username'), avatar_temp_URI : self.temp}).then(
					function(response)
					{
						console.log(response);
						if(response.data.error) angular.inform(response.data.description, {type: 'danger'});
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
					username: $cookies.get('username')
				}
			}).then(
					function (response)
					{
						console.log(response)
						if(response.data.error) angular.inform(response.data.description, {type: 'danger'});
					},
					function (error)
					{
						console.log(error); 
					}
			);
		}
		
	}
	
}]);