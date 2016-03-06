main.directive('centered',['$timeout',function($timeout) {
	return {
		restrict: 'A',
		scope: true,
		link: function(scope, element, attrs) {
			
			var height, parentHeight, parentPadding;
			
			var measure = function()
			{
				height = element[0].offsetHeight;
				parentHeight = element.parent().outerHeight();
				parentPadding = parseInt(element.parent().css('padding-top'),10);
			}			
			
			var center = function()
			{
				element[0].style.top =((parentHeight-height)/2 - parentPadding) + 'px';
			}

			element[0].style.position = 'relative';
			
			measure();
			center();
			
			$timeout(function(){
				measure();
				center();
			});
			
			scope.$watch(
					function()
					{
						return element.parent().height();
					},
					function()
					{
						measure();
						center();				
					}
			);
			
			scope.$watch(
					function()
					{
						return element.parent().width();
					},
					function()
					{
						measure();
						center();				
					}
			);
			
			scope.$watch(
					function()
					{
						return element[0].offsetHeight;
					},
					function()
					{
						measure();
						center();				
					}
			);
			
			scope.$watch(
					function()
					{
						return element[0].offsetWidth;
					},
					function(newValues)
					{
						measure();
						center();				
					}
			);
			
			
		}
	}
}]);