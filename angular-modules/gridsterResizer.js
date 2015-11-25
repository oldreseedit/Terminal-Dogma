main.controller('gridsterResizeController',['$scope','$element','$timeout',function($scope, $element,$timeout){
	var self = this;
	
	self.resize = function(element)
    {    	
    	if(self.outerHeight === self.innerHeight + self.panelHeaderHeight || self.innerHeight === 0 || self.innerHeight === undefined || self.innerHeight === null)
    	{
    		return;
    	}
    	if(self.outerHeight < self.innerHeight + self.panelHeaderHeight)
    	{
    		scope = element.parents('[gridster-item]').scope();
//    		console.log(scope.index);
    		$scope.gridsterItems[scope.index].measures.height++;
//    		console.log($scope.gridsterItems);
    	}
    	else return;    	
    };
    
    /* Watches if gridster has been initialized */ 
    $scope.$on('gridster-item-initialized',function(item){
    	$scope.ready = true;
        $timeout(function(){
        	self.panelHeaderHeight = $('.course-panel-title').height();
            self.content = $element.find('[gridster-content]');
			self.outerHeight = $element[0].offsetHeight;
            self.innerHeight = self.content[0].offsetHeight;
        });
    });
	
	$scope.$on('gridster-item-resized',function(item){
		self.outerHeight = $element[0].offsetHeight;
		self.resize(self.content);
	});
	
	$scope.$watch(
			function()
			{
				return self.innerHeight;
			},
			function(content)
			{
					if(content)
					{
						self.resize(self.content);
					}
			}
	);
	
}]);