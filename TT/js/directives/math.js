tt.directive('math',['$timeout',function($timeout){
	return {
		restrict : 'A',
		link : function($scope, $element, $attrs)
		{
			$element.addClass('animated-fastest');
			$element.css('opacity',0);
			
			var appear = function(){
				$element.addClass('fadeIn');
				$element.removeClass('fadeOut');		
			}
			var disappear = function(){
				$element.addClass('fadeOut');
				$element.removeClass('fadeIn');				
			}
			
			
			$scope.$on('beginOfTypeset', function(){
				disappear();
			});
			
			$scope.$on('endOfTypeset', function(){
				appear();
			});		
			
			$scope.$on('MathJaxLoaded', function(){
				appear();
			});		
			
		}
	};
}]);
