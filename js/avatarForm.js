main.controller('avatarFormController',['$scope','$http','$timeout','$cookies','$window',function($scope,$http,$timeout,$cookies,$window){
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
	
	self.uploadTempAvatar = function(event)
	{
		console.log(event);
		if(event) 
		{
			var tempAvatar = event.target.files;
			console.log(tempAvatar);
//			Qui dovrò chiamare il metodo di titto per caricare l'avatar TEMPORANEAMENTE, per poi
//			self.temp = URI;
		}
	};
	
}]);