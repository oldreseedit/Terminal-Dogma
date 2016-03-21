tt.directive('math',['$timeout','$compile',function($timeout,$compile){
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
				$compile($element.contents())($scope);
				disappear();
			});
			
			$scope.$on('endOfTypeset', function(){
				$compile($element.contents())($scope);
				appear();
			});		
			
			$scope.$on('MathJaxLoaded', function(){
				$compile($element.contents())($scope);
				appear();
			});		
			
		}
	};
}]);

tt.directive('mathObject',[function(){
	return {
		restrict : 'A',
		scope : true,
		link : function($scope,$element,$attrs)
		{
			$scope.mathObject = $scope.$eval($attrs.mathObject) || null;			
		}
	};
}]);