main.directive('equalHeight',['$timeout',function($timeout){
	return {
		restrict: 'A',
		link: function($scope,$element,$attrs)
		{
			if(!imOnResponsive)
			{
				var targetName = $scope.$eval($attrs.equalHeight);
				var target = (targetName && targetName !== '') ? $('#'+targetName) : $element.parent().find('[equal-height]');
				var height = 0;
				var timer;
				if(target.length > 0)
				{
					$scope.$watchCollection(
						function()
						{
							target.each(function(){
								var h = $(this).height();
								if(height < h) height = h;
							});
							return height;
						},
						function(newValue)
						{					
//							console.log(newValue, $element.height());
							if(newValue > 0 && Math.abs(newValue - $element.height()) > 1)
							{
								$timeout.cancel(timer);
								timer = $timeout(function(){$element.height(newValue);},100);
							}
						}
					);
				}
			}			
		}
	};
}]);