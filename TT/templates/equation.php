<div id="TT-equation" ng-init="equation.index=0;">

	<div class="well"><h5>\[ 2x - 3 = 1 \]</h5>
<!-- 		<div class="show-next-step" ng-click="equation.index++" ng-show="equation.index === 0"><i class="fa fa-3x fa-play green fa-rotate-90"></i></div> -->
<!-- 		<div class="show-all-steps" ng-click="equation.index=3" ng-show="equation.index === 0"><i class="fa fa-3x fa-forwardwater fa-rotate-90"></i></div> -->
	</div>
	<div class="well" ng-show="equation.index>0"><h5>\[ 2x = 4 \]</h5><div class="show-next-step" ng-click="equation.index++" ng-show="equation.index === 1"></div></div>
	<div class="well"ng-show="equation.index>1"><h5>\[ x  = 2 \]</h5></div>

</div>