main.directive('math',[function(){
	return {
		restrict : 'A',
		link : function($scope, $element, $attrs)
		{
			$element.addClass('animated-fast');
			$element.css('visibility', 'hidden');
			$scope.$on('endOfTypeset', function(){
				$element.addClass('fadeIn');
				$element.css('visibility','visible');
			});			
		}
	};
}]);
