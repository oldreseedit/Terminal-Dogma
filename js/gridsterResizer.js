main.controller('gridsterResizeController',['$scope','$element','$timeout','$http','$route','$cookies',function($scope, $element,$timeout,$http,$route,$cookies){
	var self = this;
	
	self.updateScrollbar = function()
	{
		var content = $element.find('[gridster-content]');
		var innerHeight = content[0].offsetHeight;
		var panelHeaderHeight = $('.panel-title').height() ;
		var outerHeight = $element[0].offsetHeight;
		content.attr('style','height:'+(outerHeight-panelHeaderHeight)+'px');
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
			self.timer = setTimeout(function(){self.deregisterWatchers();},500);
		}
		return;
	};

	/* Watches if gridster has been initialized */ 
	$scope.$on('gridster-item-initialized',function(item){
		$scope.ready = true;
//		angular.forEach($scope.gridsterItems, function(item){
//			console.log(item);
//			console.log(item.measures.position.x, item.measures.position.y);
//		});
		
	});

	if(!$scope.measuresLoaded)
	{
		
		self.timer = setTimeout(function(){self.deregisterWatchers();},500);

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
							clearTimeout(self.timer);
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
//			
//			console.log('Sono ', $scope.gridsterItems[$scope.index]);
//			for(var i=0; i<$scope.gridsterItems.length; i++)
//			{
//				var thisItem = $scope.gridsterItems[i];
//				console.log('', thisItem, ' \t ', thisItem.measures.position.x, thisItem.measures.position.y );				
//			}
			
//			self.setProperPositions();
			
			$scope.registerMeasures();
			
			self.updateScrollbar();

			$scope.$on('gridster-item-transition-end',
				function()
				{
					self.updateScrollbar();
				}
			);
		}	
	}
	else
	{
		$timeout(function(){self.updateScrollbar();});
		
		$scope.$on('gridster-item-transition-end', 
			function()
			{
				if($route.current.params.hasOwnProperty('courseID'))
				{
					$http.post('course/save_block_positions',{username: $cookies.get('username'), courseID: $route.current.params.courseID, blockPositions: JSON.stringify($scope.gridsterItems)}).then(
			    			function(response)
			    			{
//			    				console.log(response);
			    			},
			    			function(error)
			    			{
			    				console.log(error);
			    			}
			    	);
				}
				if($route.current.params.hasOwnProperty('userID'))
				{
					$http.post('profile/save_block_positions',{username: $cookies.get('username'), blockPositions: JSON.stringify($scope.gridsterItems)}).then(
			    			function(response)
			    			{
//			    				console.log(response);
			    			},
			    			function(error)
			    			{
			    				console.log(error);
			    			}
			    	);
				}
			
				self.updateScrollbar();				
			}
		);
	}
	
	self.setProperPositions = function()
	{
		var row = [];
		var temp=0;
		var oldY = 1;
		var counter = 0;
		var items = $scope.gridsterItems;
		for(var i = 0; i < items.length; i++)
		{
			var width =  items[i].measures.width;
			if(temp + width <= 12)
			{
				row.push(items[i]);
				temp += width;
			}
			if(temp === 12)
			{
				console.log(row);
				
				if(counter === 0) for(j=0; j < row.length; j++) row[j].measures.position.y = 0; 
				
				var heights = [];
				for(var j=0; j < row.length; j++) heights.push(row[j].measures.height); 
				
				var maxHeight = Math.max.apply(null,heights);
				
				console.log(maxHeight);
				
				var newY =  maxHeight + oldY;
				
				console.log(newY);
				
				for(j=0; j < row.length; j++) row[j].measures.position.y = newY; 
				
				oldY = newY;
				counter++;
				temp = 0;
				row = [];
			}			
		}
	}


}]);