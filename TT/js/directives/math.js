tt.directive('mathBind',['$timeout','$compile',function($timeout,$compile){
	return {
		restrict : 'A',
		link : function($scope, $element, $attrs)
		{
			var ready = false;
			$scope.$on('MathJaxLoaded',function(){
				ready = true;
			});
			
			$scope.$watch($attrs.mathBind,
				function(texExpression)
				{
					if(ready)
					{
						$element.html(texExpression);					
			            MathJax.Hub.Queue(["Typeset", MathJax.Hub, $element[0]]);
					}
				}
			);
		}
	};
}]);