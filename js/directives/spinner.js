main.directive('spinner',['ajaxEvents','$timeout',function(ajaxEvents,$timeout){
	return {
		restrict: 'A',
		scope: true,
		link : function($scope, $element, $attrs){

//			var el = $element.find('spinner-place').length > 0 ? $element.find('spinner-place') : null;
//			var elToHide = $element.find('[spinner-final], .spinner-final').length > 0 ? $element.find('[spinner-final], .spinner-final') : null;
//			console.log(el, elToHide);
			var id;
			
			$scope.$watch(
					function()
					{
						return $scope.$eval($attrs.spinner);
					},
					function(newValue)
					{
						if(newValue !== undefined)
						{
							id = $scope.$eval($attrs.spinner).id;
						}
					}
			);
			
//			$scope.pending = true;
			
			$scope.$watch(
					function()
					{
						return ajaxEvents.get(id);
					},
					function(newValue)
					{
//						console.log(newValue);	
						if(newValue !== undefined)
						{
							$scope.pending = newValue;
						}						
					}
			);
		}
	}
}]);

main.directive('spinnerPlace',[function(){
	return {
		restrict: 'E',
		scope: true,
		template : '<i class="fa fa-spinner fa-spin dark-green"></i>',
		link : function($scope, $element, $attrs)
		{			
			$scope.$watch('pending',function(newValue){
				if(newValue !== undefined) newValue ? $element.removeClass('ng-hide')  : $element.addClass('ng-hide');
			});
//			console.log($scope);
		}		
	}
}]);

main.directive('spinnerFinal',function(){
	return {
		restrict : 'ACE',
		scope : false,
		link : function($scope, $element, $attrs)
		{
			$scope.$watch('pending',function(newValue){
				if(newValue !== undefined) newValue ? $element.addClass('ng-hide') : $element.removeClass('ng-hide');
			});
		}
	}
});