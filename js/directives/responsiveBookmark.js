main.directive('bookmarks',function(){
	return {
		restrict: 'A',
		controller: 'bookmarkController'
	};
});

main.directive('bookmarkCategory',['$swipe','$timeout','$compile',function($swipe,$timeout,$compile){
	return {
		restrict: 'AEC',
		scope : false,
		require : '^bookmarks',
		replace: true,
		template: '<div class="category-bookmark animated-class ms150"><div class="bookmark-tail"></div><div class="bookmark-content">'+
			'<span class="middler"></span><h4 class="inline middle no-padding" ng-bind="category.name" ng-class="courses.getColours(indexOfCategory)"></h4>'+
			'</div> </div>',
		link : function($scope, $element, $attrs, $ctrl)
		{
			$element.css('right', $element.css('right'));
			$element.css('top', 0);
			
		    var right = $element.css('right');
		    var margin = parseInt($element.css('margin-top'));
		    var index = $scope.indexOfCategory;
		    var startPosition = {};
		    var endPosition = {};
		    var hasMoved = false;
		    var screenWidth = window.innerWidth ? window.innerWidth : screen.width;
		    var minRight = -0.22*screenWidth;
		    var normalRight = parseInt(right);
		    var height = $element.height();
		    var numberOfCourses;
		    
		    $scope.$watch(
		    		function()
		    		{
		    			if($scope.$parent.$parent.courses.categories[$ctrl.selected]) return $scope.$parent.$parent.courses.categories[$ctrl.selected].tiles.length;
		    		},
		    		function(newValue){
		    			if(newValue > 0) numberOfCourses = newValue;
		    		}
		    );
		     
		    
		    var bounceRight = function()
		    {
		    	// I phase
		    	$element.css('right',minRight);
		    	
		    	// II phase
		    	$timeout(function(){
		    		$element.css('right', -screenWidth);
		    	},200);
		    	
		    	// IV phase
		    	$timeout(function(){
		    		disappear();
		    	},600);
		    };
		    
		    var bounceLeft = function()
		    {
		    	// I phase
		    	$element.css('right',minRight);
		    	
		    	// II phase
		    	$timeout(function(){
		    		$element.css('right', normalRight);
		    	},200);
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
		    
		    var disappear = function()
		    {
	    		$element.css('display','none');
		    };
		    
		    var reappear = function()
		    {
	    		$element.css('display','block');
		    };
		    
		    var letCoursesAppear = function()
		    {
				$element.removeClass('ms150');
				$element.css('top','0');	
				var el = $compile('<bookmark-course ng-repeat="course in category.tiles" ng-init="indexOfCourse = $index"></bookmark-course>')( $scope );
				$element.parent().append(el);
				$timeout(function(){
					$element.addClass('ms150');
				});
		    };
		    
		    var letCoursesDisappear = function()
		    {
				$element.removeClass('ms150');
				$element.css('top',-(height+margin)*index);	
				$element.parent().find('.course-bookmark').remove();
				$timeout(function(){
					$element.addClass('ms150');
				});
		    };
		    
		    $scope.$watch(
		    		function()
		    		{
		    			return $ctrl.selected;
		    		},
		    		function(newValue, oldValue)
		    		{
//		    			console.log(oldValue + ' -> ' + newValue);
		    			
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
		    				},400);

		    		    	// IV phase SELECTION
	    					$timeout(function(){
	    						letCoursesAppear();
	    					},600);
		    			}
		    			if(newValue === -1 && $ctrl.oldSelected !== index)
		    			{
		    				// II phase NOSELECTION
		    				$timeout(function(){
			    		    	reappear();			
		    				},200);
		    				
		    				// IV phase NOSELECTION
		    				$timeout(function(){
			    				bounceLeft();		    					
		    				},600);		    		
		    			}
		    			if(newValue === -1 && $ctrl.oldSelected === index)
		    			{
		    				// I phase NOSELECTION
		    				rightToYourPosition();
		    				
		    				// II phase NOSELECTION
	    					$timeout(function(){
		    					letCoursesDisappear();
	    					},200);

		    				// III phase NOSELECTION
		    				$timeout(function(){
		    					backToYourPosition();
		    				},400);
		    			}
		    			
		    		}
		    );
		    
		    $element.bind('click',function(){
		    	$timeout(function(){
		    		$ctrl.toggleSelection(index);
//					console.log($ctrl);
		    	});
		    });
			
			$swipe.bind($element,{
				start : function(coordinates)
				{
					right = parseInt($element.css('right'));
					startPosition.x = coordinates.x;
					startPosition.y =  coordinates.y;

					hasMoved = false;
					
//					console.log(coordinates, right, startPosition);
				},
				move : function(coordinates)
				{
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
			'<span class="middler"></span><h6 class="inline middle no-padding white" ng-bind="course.title"></h6>'+
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
		    var minRight = -0.22*screenWidth;
		    var normalRight = parseInt(right);
		    var index = $scope.indexOfCourse;
			
		    $element.css('top', -(height+margin)*(index+1));
			
			 $scope.$watch(
	    		function()
	    		{
	    			return $ctrl.selected;
	    		},
	    		function(newValue, oldValue)
	    		{
	    			if(newValue !== -1)
	    			{
	    				$element.css('top',0);
	    			}
	    			else
    				{
	    				$element.css('top', -(height+margin)*(index+1));
    				}
	    		}
    		);
			
			$swipe.bind($element,{
				start : function(coordinates)
				{
					right = parseInt($element.css('right'));
					startPosition.x = coordinates.x;
					startPosition.y =  coordinates.y;
					
//					console.log(coordinates, right, startPosition);
				},
				move : function(coordinates)
				{
					$element.removeClass('ms150');
					
					var position = normalRight - (coordinates.x - startPosition.x);
					
					$element.css('right', position < normalRight ? normalRight : (position > minRight ? minRight : position) );
				},
				end : function(coordinates,event)
				{
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