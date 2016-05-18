main.directive('equalHeight',['$timeout',function($timeout){
	return {
		restrict: 'A',
		link: function($scope,$element,$attrs)
		{
			var event = 'EH';
			if($attrs.equalHeightWaitFor) event = $attrs.equalHeightWaitFor;
			else $timeout( function(){ $scope.$parent.$broadcast(event);}, 100); 
			$scope.$on(event,function(){
				if(!imOnResponsive)
				{
					var targetName = $scope.$eval($attrs.equalHeight);
					var target = (targetName && targetName !== '') ? $('#'+targetName) : $element.parent().find('[equal-height]');
//					console.log('PRE',$element,targetName,target);
					var height = 0;
					var timer;
					if(target.length > 0)
					{
						$scope.$watchCollection(
							function()
							{
								target.each(function(){
									var h = Math.max($(this).height(), $element.height());
									if(height < h) height = h;
								});
								return height;
							},
							function(newValue)
							{
//								console.log($element, newValue, $element.height());
								$timeout.cancel(timer);
								timer = $timeout(function(){
									if(newValue > 0 && Math.abs(newValue - $element.height()) > 1)
									{
										$element.height(newValue);
									}
								},100);
							}
						);
					}
				}			
			});			
		}
	};
}]);