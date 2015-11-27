main.controller('gridsterResizeController',['$scope','$element','$timeout',function($scope, $element,$timeout){
	var self = this;
	
	self.timer = setTimeout(function(){self.deregisterWatchers();},100);
	
	self.resize = function(element)
    {
		if(element === undefined) return;
//		console.log('Resize: sono stato chiamato con le seguenti misure: ', self.innerHeight, self.panelHeaderHeight, self.outerHeight);
    	if(self.innerHeight === 0 || self.innerHeight === undefined || self.innerHeight === null || self.panelHeaderHeight === undefined)
    	{
    		return;
    	}
    	if(self.outerHeight < self.innerHeight + self.panelHeaderHeight)
    	{
    		scope = element.parents('[gridster-item]').scope();
    		$scope.gridsterItems[scope.index].measures.height++;
    		self.timer = setTimeout(function(){self.deregisterWatchers();});
    	}
    	else return;
    };
    
    /* Watches if gridster has been initialized */ 
    $scope.$on('gridster-item-initialized',function(item){
    	$scope.ready = true;
//    	console.log(item);
    });
    
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
//						console.log('Il contenuto è stato caricato');
						self.panelHeaderHeight = $('.course-panel-title').height();
						self.innerHeight = newHeight;
						self.content = $element.find('[gridster-content]');
						self.outerHeight = $element[0].offsetHeight;
//						console.log(self.content[0], oldHeight + ' -> ' + newHeight);
			 			self.resize(self.content);
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
//					console.log('Le misure sono cambiate in: ', self.innerHeight, self.panelHeaderHeight, self.outerHeight);
					self.resize(self.content);			
				}
		}
	);
	
	self.deregisterWatchers = function()
	{
		self.deregisterInnerHeight();
		self.deregisterOuterHeight();
		
		$scope.$on('gridster-item-transition-end',
				function()
				{
					var content = $element.find('[gridster-content]');
					var innerHeight = content[0].offsetHeight;
					var panelHeaderHeight = $('.course-panel-title').height();
					var outerHeight = $element[0].offsetHeight;
					content.attr('style','height:'+(outerHeight-panelHeaderHeight)+'px');
					content.perfectScrollbar('update');
				}
		);
		
		
	}	
	
}]);