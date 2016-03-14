main.directive('bookmarks',function(){
	return {
		restrict: 'A',
		controller: 'bookmarkController',
		link : function($scope, $element, $attrs)
		{
//			console.log($scope);
			
			var maxNumberOfCourses = 0;
			
		    $scope.$watch(
		    		function()
		    		{
		    			if($scope.$parent.courses.categories) return $scope.$parent.courses.categories;
		    		},
		    		function(categories){
		    			if(categories.length > 0)
		    			{
		    				for(var i=0; i<categories.length; i++)
		    				{
		    					if(categories[i].tiles)
		    					{
		    						if(maxNumberOfCourses < categories[i].tiles.length) maxNumberOfCourses = categories[i].tiles.length;
		    					}
		    				}
		    			    var margin = parseInt($element.find('.category-bookmark').css('margin-top'));
		    			    var height = $element.find('.category-bookmark').height();
		    			    
		    				$element.css('height',(height+margin)* Math.max( maxNumberOfCourses + 1, categories.length ) );
		    			}
		    		},
		    		true
		    );
		}
	};
});

main.directive('bookmarkCategory',['$swipe','$timeout','$compile',function($swipe,$timeout,$compile){
	return {
		restrict: 'AEC',
		scope : false,
		require : '^bookmarks',
		replace: true,
		template: '<div class="category-bookmark animated-class ms150"><div class="bookmark-tail"></div><div class="bookmark-content">'+
			'<span class="middler"></span><h4 class="inline middle noselect no-padding" ng-bind="category.name" ng-class="courses.getColours(indexOfCategory)"></h4>'+
			'</div> </div>',
		link : function($scope, $element, $attrs, $ctrl)
		{
			$element.css('right', $element.css('right'));
			$element.css('top', 0);
			
		    var right = $element.css('right');
		    var margin = parseInt($element.css('margin-top'));
		    var height = $element.height();
		    var index = $scope.indexOfCategory;
		    var startPosition = {};
		    var endPosition = {};
		    var hasMoved = false;
		    var screenWidth = window.innerWidth ? window.innerWidth : screen.width;
		    var minRight = -0.22*screenWidth;
		    var normalRight = parseInt(right);
			var isAnimating = false;
		    

			var el = $compile('<bookmark-course ng-repeat="course in category.tiles" ng-init="indexOfCourse = $index"></bookmark-course>')( $scope );
			$element.parent().append(el);
		    
		    // TODO: RIVEDI TUTTO COME EVENTI!
		    
		    var bounceRight = function()
		    {
		    	// I phase
		    	$element.css('right',minRight);
		    	
		    	// II phase
		    	$timeout(function(){
		    		$element.css('right', -screenWidth);
		    	},250);
		    };
		    
		    var bounceLeft = function()
		    {
		    	// I phase
		    	$element.css('right',minRight);
		    	
		    	// II phase
		    	$timeout(function(){
		    		$element.css('right', normalRight);
		    	},250);
		    };
		    
		    var goToTop = function()
		    {
    			$element.css('top', -(height+margin)*index);
		    };
		    
		    var backToYourPosition = function()
		    {
    			$element.css('top', 0);
		    };
		    
		    var rightToYourPosition = function()
		    {
		    	$element.css('right',normalRight);
		    };
		    
		    $scope.$watch(
		    		function()
		    		{
		    			return $ctrl.selected;
		    		},
		    		function(newValue, oldValue)
		    		{
//		    			console.log(oldValue + ' -> ' + newValue);
		    			isAnimating = true;
		    			
		    			if(index !== newValue && newValue !== -2 && newValue !== -1)
		    			{
		    		    	// I-IV phase SELECTION
		    				bounceRight();
		    			}
		    			if(index === newValue)
		    			{
		    		    	// I phase SELECTION
		    				rightToYourPosition();

		    		    	// III phase SELECTION
		    				$timeout(function(){
		    					goToTop();
		    				},500);
		    			}
		    			if(newValue === -1 && $ctrl.oldSelected !== index)
		    			{		    				
		    				// IV phase NOSELECTION
		    				$timeout(function(){
			    				bounceLeft();		    					
		    				},750);		    		
		    			}
		    			if(newValue === -1 && $ctrl.oldSelected === index)
		    			{
		    				// I phase NOSELECTION
		    				rightToYourPosition();

		    				// III phase NOSELECTION
		    				$timeout(function(){
		    					backToYourPosition();
		    				},500);
		    			}
				    	
				    	$timeout(function(){
							isAnimating = false;		    		
				    	},1000);
		    		}
		    );
		    
		    $element.bind('click',function(){
				if(isAnimating) return;
		    	$timeout(function(){
		    		$ctrl.toggleSelection(index);
//					console.log($ctrl);
		    	});
		    });
			
			$swipe.bind($element,{
				start : function(coordinates)
				{
					if(isAnimating) return;
					right = parseInt($element.css('right'));
					startPosition.x = coordinates.x;
					startPosition.y =  coordinates.y;

					hasMoved = false;
					
//					console.log(coordinates, right, startPosition);
				},
				move : function(coordinates)
				{
					if(isAnimating) return;
//					console.log(coordinates, startPosition);
					if(coordinates.x !== startPosition.x || coordinates.y !== startPosition.y)
					{
						hasMoved = true;
						$element.removeClass('ms150');
						
						var position = normalRight - (coordinates.x - startPosition.x);
						
						$element.css('right', position < normalRight ? normalRight : (position > minRight ? minRight : position) );
					}
					else hasMoved = false;
				},
				end : function(coordinates,event)
				{
					if(isAnimating) return;
					right = parseInt($element.css('right'));
					$element.addClass('ms150');

					if(hasMoved && right !== normalRight)
					{
				    	$timeout(function(){
				    		$ctrl.toggleSelection(index);
//							console.log($ctrl);
				    	});
					}
				},
				cancel : function()
				{	
					if(isAnimating) return;				
					right = parseInt($element.css('right'));
					$element.addClass('ms150');

					if(hasMoved && right !== normalRight)
					{
				    	$timeout(function(){
				    		$ctrl.toggleSelection(index);
//							console.log($ctrl);
				    	});
					}	
				}
			});
		}		
	};
}]);

main.directive('bookmarkCourse',['$swipe','$timeout','$location',function($swipe,$timeout,$location){
	return {
		restrict: 'AEC',
		scope : false,
		require : '^bookmarks',
		replace: true,
		template: '<div class="course-bookmark animated-class ms150" ng-class="courses.getBgColours(indexOfCategory)"><a ng-href="/courses/{{course.url}}"><div class="bookmark-tail"></div><div class="bookmark-content">'+
			'<span class="middler"></span><h6 class="inline middle no-padding noselect white" ng-bind="course.title"></h6>'+
			'</div> </a></div>',
		link : function($scope, $element, $attrs, $ctrl)
		{
			$element.css('right', $element.css('right'));
//			$element.css('display', 'none');
			
		    var right = $element.css('right');
		    var margin = parseInt($element.css('margin-top'));
		    var height = $element.height();
		    var startPosition = {};
		    var endPosition = {};
		    var hasMoved = false;
		    var screenWidth = window.innerWidth ? window.innerWidth : screen.width;
		    var minRight = -0.05*screenWidth;
		    var normalRight = parseInt(right);
		    var index = $scope.indexOfCourse;
		    var isAnimating = false;

			$element.css('visibility','hidden');
			$element.css('top',-margin);
			
			 $scope.$watch(
	    		function()
	    		{
	    			return $ctrl.selected;
	    		},
	    		function(newValue, oldValue)
	    		{
	    			if(newValue === -1)
	    			{
	    				isAnimating = true;
						$element.css('top', -margin);
    					$timeout(function(){
    	    				$element.css('visibility','hidden');
        					isAnimating = false;    						
    					},250);
	    			}
	    			if(newValue === $scope.$parent.indexOfCategory)
    				{
//	    				console.log($element);
	    				isAnimating = true;
	    				
    					$timeout(function(){
	    					$element.css('visibility','visible');
    						$element.css('top',(height+margin)*(index+1) - margin);
        					isAnimating = false;    						
    					},750);
    				}
	    		}
    		);
			
			$swipe.bind($element,{
				start : function(coordinates)
				{
					if(isAnimating) return;
					right = parseInt($element.css('right'));
					startPosition.x = coordinates.x;
					startPosition.y =  coordinates.y;
					
//					console.log(coordinates, right, startPosition);
				},
				move : function(coordinates)
				{
					if(isAnimating) return;
					$element.removeClass('ms150');
					
					var position = normalRight - (coordinates.x - startPosition.x);
					
					$element.css('right', position < normalRight ? normalRight : (position > minRight ? minRight : position) );
				},
				end : function(coordinates,event)
				{
					if(isAnimating) return;
					right = parseInt($element.css('right'));
					$element.addClass('ms150');

					if(right !== normalRight)
					{
				    	$timeout(function(){
				    		
				    		$location.path('/courses/'+$scope.course.url);
				    	});
					}
				},
				cancel : function()
				{
					if(isAnimating) return;					
					right = parseInt($element.css('right'));
					$element.addClass('ms150');

					if(right !== normalRight)
					{
				    	$element.css('right',normalRight);
					}	
				}
			});
		}		
	};
	
}]);