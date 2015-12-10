main.controller('gridsterResizeController',['$scope','$element','$timeout','$http','$route','$cookies',function($scope, $element,$timeout,$http,$route,$cookies){
	var self = this;
	
	self.updateScrollbar = function()
	{
		var content = $element.find('.panel-content');
		var panelHeaderHeight = $('.panel-title').height() ;
		var outerHeight = $element.height();
		content.attr('style','height:'+(outerHeight-panelHeaderHeight)+'px');
		content.find('.scrollbar-wrapper').attr('style','height:'+content.height()+'px');
		content.perfectScrollbar('update');
	};
	
	self.resize = function(element)
	{
		if(element === undefined) return;
		if(self.innerHeight === 0 || self.innerHeight === undefined || self.innerHeight === null || self.panelHeaderHeight === undefined)
		{
			return;
		}
		if(self.outerHeight < self.innerHeight + self.panelHeaderHeight)
		{
			if($scope.gridsterItems[$scope.index].measures.height < 7)
			{
				$scope.gridsterItems[$scope.index].measures.height++;
			}	
//			self.timer = setTimeout(function(){self.deregisterWatchers();},500);
		}
		return;
	};

	/* Watches if gridster has been initialized */ 
	$scope.$on('gridster-item-initialized',function(item){
		$scope.ready = true;

		if(!$scope.measuresLoaded)
		{
			
	//		self.timer = setTimeout(function(){self.deregisterWatchers();},500);
	
			self.deregisterInnerHeight = 
				$scope.$watch(
						function()
						{
							if($element.find('[gridster-content]')[0]) return $element.find('[gridster-content]')[0].offsetHeight;
						},
						function(newHeight, oldHeight)
						{
							if(newHeight !== undefined && newHeight > 0 && newHeight !== oldHeight)
							{
	//							clearTimeout(self.timer);
	//							console.log('Il contenuto è stato caricato');
								self.panelHeaderHeight = $('.panel-title').height();
								self.innerHeight = newHeight;
								self.content = $element.find('[gridster-content]');
								self.outerHeight = $element[0].offsetHeight;
	//							console.log(self.content[0], oldHeight + ' -> ' + newHeight);
								self.resize(self.content);
	
	//							console.log('Sono ', $scope.gridsterItems[$scope.index].title, ' e la mia nuova altezza è ', $scope.gridsterItems[$scope.index].measures.height);
	//							for(var i=0; i<$scope.gridsterItems.length; i++)
	//							{
	//								var thisItem = $scope.gridsterItems[i];
	//								console.log('', thisItem.title, ' \t x = ', thisItem.measures.position.x, ' y = ', thisItem.measures.position.y, ' height = ', thisItem.measures.height );				
	//							}
							}
						}
				);
	
			self.deregisterOuterHeight = 
				$scope.$watch(
						function()
						{
							if($element[0]) return $element[0].offsetHeight;
						},
						function(newHeight, oldHeight)
						{
							if(self.content !== undefined && newHeight !== undefined && newHeight > 0 && newHeight !== oldHeight)
							{
								self.outerHeight = $element[0].offsetHeight;
								
	//							console.log('Le misure sono cambiate in: ', self.innerHeight, self.panelHeaderHeight, self.outerHeight, $scope.gridsterItems[$scope.index].measures.position.x,$scope.gridsterItems[$scope.index].measures.position.y);
								
								self.resize(self.content);	
	
	//							console.log('Sono ', $scope.gridsterItems[$scope.index].title, ' e la mia nuova altezza è ', $scope.gridsterItems[$scope.index].measures.height);
	//							for(var i=0; i<$scope.gridsterItems.length; i++)
	//							{
	//								var thisItem = $scope.gridsterItems[i];
	//								console.log('', thisItem.title, ' \t x = ', thisItem.measures.position.x, ' y = ', thisItem.measures.position.y, ' height = ', thisItem.measures.height );				
	//							}		
							}
						}
				);
	
			self.deregisterWatchers = function()
			{
				self.deregisterInnerHeight();
				self.deregisterOuterHeight();
				
	//			if($route.current.locals.username === $scope.username || $scope.admin) $scope.registerMeasures();
				
				$timeout(function(){self.updateScrollbar();});
	
				$scope.$on('gridster-item-transition-end',
					function()
					{
						self.updateScrollbar();
					}
				);
			}	
		}
		else // If measures are loaded
		{
			$timeout(function(){self.updateScrollbar();});
			
			$scope.$on('gridster-item-transition-end', 
				function()
				{
					if($route.current.locals.username === $scope.username || $scope.admin) $scope.registerMeasures();
				
					self.updateScrollbar();				
				}
			);
		}
	});
	
}]);