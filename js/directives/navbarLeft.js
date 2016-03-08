main.directive('navbarLeft',['$swipe',function($swipe){
	return {
		restrict: 'AEC',
		link: function($scope, $element, $attrs)
		{
			$element.addClass('animated-class-fastest');
			$element.css('left', 0);
			
			var startPosition;
			var hasMoved = false;
			var isOpened = false;
			var left;
			var menuWidth = $element.find('#menu').width();
			var buttonStart = $element.find('#navbar-toggle')[0].offsetTop;
			var buttonEnd = buttonStart + $element.find('#navbar-toggle')[0].offsetHeight;
			
			$swipe.bind($element, {
				start : function(event)
				{
					left = $element.css('left');
					
					if( left !== '0px' && left !== 'auto') isOpened = true;
					else isOpened = false;
					
					startPosition = isOpened ? event.x - parseInt(left) : event.x;
					
					console.log(event.x, left, startPosition, isOpened);
				},
				move : function(event)
				{
					hasMoved = true;
					$element.removeClass('animated-class-fastest');
					$element.css('left', Math.max(0, Math.min(event.x - startPosition, menuWidth)) );
				},
				end : function(event)
				{
//					console.log(event);
					$element.addClass('animated-class-fastest');
					if(hasMoved)
					{
						if( event.x < (menuWidth + $element.width())/2 ) $element.css('left',0);
						else $element.css('left',  menuWidth); 						
					}
					else
					{
						console.log(event);
						if(isOpened && event.x > menuWidth) $element.css('left',0);
						if(!isOpened && event.y > buttonStart && event.y < buttonEnd) $element.css('left',  menuWidth);
					}
					
					hasMoved = false;
				},
				cancel : function(event)
				{
					$element.addClass('animated-class-fastest');
					if(hasMoved)
					{
						if( event.x < (menuWidth + $element.width())/2 ) $element.css('left',0);
						else $element.css('left',  menuWidth); 						
					}
					else
					{
						console.log(event);
						if(isOpened && event.x > menuWidth) $element.css('left',0);
						if(!isOpened && event.y > buttonStart && event.y < buttonEnd) $element.css('left',  menuWidth);
					}
					
					hasMoved = false;					
				}
			});
		}
	};
	
}]);