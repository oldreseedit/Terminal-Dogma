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
			
			$swipe.bind($element, {
				start : function(event)
				{
					left = $element.css('left');
					
					isOpened = (left !== '0px' && left !== 'auto');
					
					startPosition.x = isOpened ? event.x - parseInt(left) : event.x;
					startPosition.y =  event.y;
					
//					console.log(event.x, left, startPosition.x, isOpened);
				},
				move : function(event)
				{
//					console.log(startPosition.x);
					if( startPosition.x < 8 || ( startPosition.y < buttonEnd && startPosition.y > buttonStart ) )
					{
						if(event.x !== startPosition.x || event.y !== startPosition.y) hasMoved = true;
						$element.removeClass('animated-class-fastest');
						$element.css('left', Math.max(0, Math.min(event.x - startPosition.x, menuWidth)) );						
					}
				},
				end : function(event)
				{
//					console.log('end!');
					
					left = $element.css('left');
					
					var changedOpening = (left !== '0px' && left !== 'auto') !== isOpened;
					var endPosition = isOpened ? event.x - menuWidth : event.x;

					$element.addClass('animated-class-fastest');	
					
					if(!changedOpening && startPosition.x < $element.width()  && startPosition.x > -1  && ( !isOpened ? (startPosition.y < buttonEnd && startPosition.y > buttonStart) : true ) && endPosition < $element.width() && endPosition  > -1)
					{
						if( parseInt(left) < menuWidth/2 ) swipeRight();
						else swipeLeft();
					}
					else
					{
						if( parseInt(left) < menuWidth/2) swipeLeft();
						else swipeRight();						
					}
					hasMoved = false;
				},
				cancel : function(event)
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