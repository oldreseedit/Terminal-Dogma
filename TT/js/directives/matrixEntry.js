tt.directive('mjxMn',['$timeout',function($timeout){
	return {
		restrict : 'C',
		link : function($scope, $element, $attrs)
		{
			
			var mathObject = $element.closest('[math-object]');;
			
			if(mathObject.length>0 && $.contains(mathObject[0], $element[0]) )
			{
				$element.addClass('clickable');
				
				$element.on('click',function(event){
					event.stopImmediatePropagation();
					
					var row = $element.closest('.mjx-mtr');
					var rows = row.parent().children();
					
					var i;
					for(var k = 0; k<rows.length; k++)
					{
						if($(rows[k]).is(row)) i=k; 
					}
					
					var j;

					var col = $element.closest('.mjx-mtd');
					for(var k = 0; k<rows.length; k++)
					{
						if($(row.children()[k]).is(col)) j=k; 
					}
					
					var changeNumber = function()
					{
						// HERE'S THE WORK
						console.log($scope, $scope.mathObject);
						$scope.mathObject.matrix[i][j]++;
					};
					
					$timeout(function(){
						$scope.reRender(changeNumber);
					});
				});			
			}
		}
	};
}]);