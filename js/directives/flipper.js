/* for flipping purposes - as element */
main.directive('flipper',function() {
	return {
		restrict: "E",
		template: "<div class='flipper' ng-transclude ng-class='{flipped : flipped}'></div>",
		transclude: true,
		scope: {
			flipped: "="
		}
	};
});

main.directive("front", function() {
	return {
		restrict: "E",
		template: "<div class='front' ng-transclude></div>",
		transclude: true
	};
});

main.directive("back", function() {
	return {
		restrict: "E",
		template: "<div class='back' ng-transclude></div>",
		transclude: true
	};
});