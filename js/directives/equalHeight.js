main.directive('equalHeight',['$timeout',function($timeout){
	return {
		restrict: 'A',
		link: function($scope,$element,$attrs)
		{
			var targetName = $scope.$eval($attrs.equalHeight);
			$scope.$watchCollection(
				function()
				{
					var target = (targetName && targetName !== '') ? $('#'+targetName) : $element.parent().find('[equal-height]');
//					console.log(target,target.height());
					var height = 0;
					if(target.length > 0)
					{
						target.each(function(){
							var h = $(this).height();
							if(height < h) height = h;
						});
						return height;
					}
				},
				function(newValue, oldValue)
				{					
//					console.log(newValue,oldValue, $element.height());
					if(newValue > 0 && Math.abs(newValue - oldValue) > 2 && newValue > $element.height() + 2) $timeout(function(){$element.height(newValue);}); 
				}
			);
		}
	};
}]);