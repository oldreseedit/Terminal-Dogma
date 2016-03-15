tt.directive('math',['$timeout',function($timeout){
	return {
		restrict : 'A',
		link : function($scope, $element, $attrs)
		{
			$element.addClass('animated-fast');
			$element.css('visibility', 'hidden');
			
			var appear = function(){
				$element.addClass('fadeIn');
				$element.removeClass('fadeOut');
				$element.css('visibility','visible');				
			}
			var disappear = function(){
				$element.css('visibility','hidden');
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
