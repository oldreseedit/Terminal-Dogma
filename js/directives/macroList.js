main.directive('macroList', [function(){
	return {
		restrict : 'AE',
		transclude: true,
		scope: {
			number: '@'
		},
		template: '<div class="container"><div class="step"><div class="step-icon padding-right-1"><div class="fa-stack fa-3x"><span class="fa-stack-2x fa fa-circle-thin"></span><span class="fa-stack-1x" ng-bind="number"></span></div></div><div class="step-content text-left" ng-transclude></div></div>'
	};
}]);

main.directive('macroListInverse', [function(){
	return {
		restrict : 'AE',
		transclude: true,
		scope: {
			number: '@'
		},
		template: '<div class="container"><div class="step"><div class="step-content text-right padding-right-1" ng-transclude></div><div class="step-icon"><div class="fa-stack fa-3x"><span class="fa-stack-2x fa fa-circle-thin"></span><span class="fa-stack-1x" ng-bind="number"></span></div></div></div>'
	};
}]);