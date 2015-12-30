main.directive('equalSpans',['$window',function($window){
	return {
		restrict: 'A',
		link: function($scope, $element, $attrs)
		{
			
			var separate = function(){
				
				var width = $element.innerWidth();
				
				var singleWidths = [];
				var elements = $element.find('[equal-span]'); 
				elements.each(function(){
					singleWidths.push($(this).width());
				});
				
				var check = true;
				var sum = 0;
				angular.forEach(singleWidths,function(singleWidth){
					if(singleWidth < 2) check = false;
					else sum+=singleWidth;
				});
				
				if(check)
				{
//					console.log(singleWidths);
					for(var i=0; i<elements.length-1; i++)
					{
						var correctMargin = Math.floor((width-sum)/(elements.length-1));
						$(elements[i]).css('margin-right',correctMargin + 'px');
					}
				}
				
			};	
			
			$scope.$on('separate',function(){
				separate();
			});

            $(window).resize(function(){
				separate();
			});
			
		}
	};
}]);

main.directive('equalSpan',[function(){
	return {
		restrict: 'A',
		link: function($scope,$element,$attrs)
		{			
			$scope.$watch(
				function()
				{
					return $element[0].offsetWidth;
				},
				function(newValue, oldValue)
				{
//					console.log(newValue);
					if(newValue > 0 && Math.abs(newValue - oldValue) > 2) $scope.$emit('separate');
				}
			);
		}
	};
}]);