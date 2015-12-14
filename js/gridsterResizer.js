main.directive('gridsterAutoResize',['$timeout',function($timeout){
	return {
		restrict: 'A',
		link: function($scope,$element,$attr)
		{
			$scope.$on('firstLoad',function()
			{
				var finished = false;

				var content = $element.find('.panel-content');
				if(!content) console.log('Couldn\'t find element with class panel-content inside gridster');
				var panelHeader = $element.find('.panel-title');
				if(!panelHeader) console.log('Couldn\'t find element with class panel-content inside gridster');
				
				var innerHeight = content.height();
				var panelHeaderHeight = panelHeader.height();
				var outerHeight = $element.height();
				
				/* Sets perfectScrollbar to panel */
				var updateScrollbar = function()
				{
					var innerHeight = content.height();
					var panelHeaderHeight = panelHeader.height();
					var outerHeight = $element.height();
					content.attr('style','height:'+(outerHeight-panelHeaderHeight)+'px');
					content.find('.scrollbar-wrapper').attr('style','height:'+innerHeight+'px');
					content.perfectScrollbar('update');
				};
				
				/* Resize Gridster item to fit its content */
				var resize = function()
				{
					var gridsterItem = $scope.gridsterItem;
					if(!gridsterItem) return;
					var exactRows = Math.min(gridsterItem.gridster.pixelsToRows(innerHeight+panelHeaderHeight,true),7);
	//				console.log(exactRows);
					gridsterItem.setSizeY(exactRows);
					if(exactRows > 1)
					{
						$timeout(function(){
							
							var img = $element.find('img');
							if(img.length > 0)
							{
	//							console.log(img);
								img.load(function(){
									finished = true;
								});
							}
							else{
								finished = true;
							}
							
							if(finished) $timeout(function(){
								var item = {};
	//							console.log(gridsterItem);
								item.measures = JSON.stringify(gridsterItem.toJSON());
								item.id = $scope.gridsterItems[$scope.index].id;
								updateScrollbar();
								$scope.registerMeasures(item);
							});
						});
					}
				};
				
				/* Watches if gridster has been initialized */ 
				$scope.$on('gridster-item-initialized',function(item){
					resize();
				});
				
				/* Watchers */
				
				$scope.$watch(
					function()
					{
						if(content) return content.height(); 
					},
					function(newValue)
					{
						innerHeight = newValue;
						if(!finished) resize();
						else updateScrollbar();
					}
				);
				
				$scope.$watch(
					function()
					{
						if(panelHeader) return panelHeader.height(); 
					},
					function(newValue)
					{
						panelHeaderHeight = newValue;
						if(!finished) resize();
						else updateScrollbar();
					}
				);
				
				$scope.$watch(
					function()
					{
						return $element.height() 
					},
					function(newValue)
					{
						outerHeight = newValue;
						if(!finished) resize();
						else updateScrollbar();
					}
				);
			});
		}
	}
}]);
			
// TODO: sviluppa meglio

main.directive('gridsterFixed',['$timeout',function($timeout){
	return {
		restrict: 'A',
		link : function($scope,$element,$attrs)
		{
			var id = $scope.gridsterItems[$scope.index].id;
			if($attrs.gridsterFixed === id)
			{
				$scope.gridsterItems[$scope.index].draggable = false;
				$scope.gridsterItems[$scope.index].resizable = false;				
			}
		}
	};
}]);