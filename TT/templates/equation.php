<div id="TT-equation">

	<h5 math ng-bind="equation.formula.display()"></h5>
	<hr>
	
	<div ng-repeat="step in equation.e.solution.steps">
		<h6 ng-bind="step.description"></h6>
		<h5 math ng-bind="step.formula.display()"></h5>
		<hr>
	</div>

</div>