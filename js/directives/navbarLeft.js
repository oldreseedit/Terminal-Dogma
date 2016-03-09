main.directive('navbarLeft',['$swipe',function($swipe){
	return {
		restrict: 'AEC',
		link: function($scope, $element, $attrs)
		{
			$element.addClass('animated-class-fastest');
			$element.css('left', 0);
			
			var startPosition = {};
			var hasMoved = false;
			var isOpened = false;
			var left;
			var menuWidth = $element.find('#menu').width();
			var buttonStart = $element.find('#navbar-toggle')[0].offsetTop;
			var buttonEnd = buttonStart + $element.find('#navbar-toggle')[0].offsetHeight;
			var interfaceWidth = parseInt($element.width());
			var haveToSwipeLeft = false;

			var swipeLeft = function()
			{
				$element.css('left',0);
				$element.width(interfaceWidth);				
			};
			
			var swipeRight = function()
			{
				$element.css('left',  menuWidth);
				$element.width('100%');				
			};
			
			$scope.$on('close-navbar',function(){ console.log('received Event!'); haveToSwipeLeft = true; });
			
			$swipe.bind($element, {
				start : function(coordinates)
				{
					left = $element.css('left');
					
					isOpened = (left !== '0px' && left !== 'auto');
					
					startPosition.x = isOpened ? coordinates.x - parseInt(left) : coordinates.x;
					startPosition.y =  coordinates.y;
					
//					console.log(coordinates.x, left, startPosition.x, isOpened);
				},
				move : function(coordinates)
				{
//					console.log(startPosition.x);
					if( startPosition.x < 8 || ( startPosition.y < buttonEnd && startPosition.y > buttonStart ) )
					{
						if(coordinates.x !== startPosition.x || coordinates.y !== startPosition.y) hasMoved = true;
						$element.removeClass('animated-class-fastest');
						$element.css('left', Math.max(0, Math.min(coordinates.x - startPosition.x, menuWidth)) );						
					}
				},
				end : function(coordinates,event)
				{
					left = $element.css('left');
					
					var changedOpening = (left !== '0px' && left !== 'auto') !== isOpened;
					var endPosition = isOpened ? coordinates.x - menuWidth : coordinates.x;

					$element.addClass('animated-class-fastest');	
					
					if(haveToSwipeLeft)
					{
						swipeLeft();
						
						isOpened = (left !== '0px' && left !== 'auto');
						if(!isOpened) haveToSwipeLeft = false;
					}
					else
					{
						if(!changedOpening && startPosition.x < $element.width()  && startPosition.x > -1  && ( !isOpened ? (startPosition.y < buttonEnd && startPosition.y > buttonStart) : true ) && endPosition < $element.width() && endPosition  > -1)
						{
							if( parseInt(left) < menuWidth/2 ) swipeRight();
							else swipeLeft();
						}
						else
						{
//							console.log(event);
							if( parseInt(left) < menuWidth/2) swipeLeft();
							else swipeRight();
//							console.log(event.isDefaultPrevented);
						}
					}
					
					hasMoved = false;
				},
				cancel : function()
				{					
					left = $element.css('left');
					
					$element.addClass('animated-class-fastest');
					if( parseInt(left) < menuWidth/2 ) swipeLeft();
					else swipeRight();

					hasMoved = false;					
				}
			});
		}
	};
	
}]);