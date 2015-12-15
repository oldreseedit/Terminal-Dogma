main.directive('gridsterAutoResize',['$timeout',function($timeout){
	return {
		restrict: 'A',
		link: function($scope,$element,$attr)
		{
			var itemID = $scope.gridsterItems[$scope.index].id;
			var event;
			switch(itemID)
			{
				case 'courseDescription':
					event = 'courses';
					break;
				case 'courseTeacher':
					event = 'teacher';
					break;
				case 'calendar':
					event = 'calendar';
					break;
				case 'courseNotifications':
					event = 'notifications';
					break;
				case 'courseMaterials':
					event = 'materials';
					break;
				case 'courseBanner':
					event = 'courses';
					break;
			}
			
			
			$scope.$on(event,function()
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
					var exactRows = Math.min(gridsterItem.gridster.pixelsToRows(innerHeight+panelHeaderHeight,true),6);
	//				console.log(exactRows);
					gridsterItem.setSizeY(exactRows);
							
					if(finished) $timeout(function(){
						var item = {};
//							console.log(gridsterItem);
						item.measures = JSON.stringify(gridsterItem.toJSON());
						item.id = $scope.gridsterItems[$scope.index].id;
						updateScrollbar();
						$scope.registerMeasures(item);
					});
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