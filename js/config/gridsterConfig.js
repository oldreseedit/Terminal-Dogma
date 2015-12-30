main.run(['gridsterConfig',function(gridsterConfig){
	gridsterConfig.swapping = true;
	gridsterConfig.mobileBreakPoint = 600;
	// gridsterConfig.rowHeight = '*3.236';
	gridsterConfig.columns = 12;
	gridsterConfig.draggable.handle = '.panel-title';	
}]);