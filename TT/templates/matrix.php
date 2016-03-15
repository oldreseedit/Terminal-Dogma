<div id="TT-matrix" ng-controller="matrixCtrl as matrix">

<form class="form-inline">
	<div><p class="inline">Numero di righe: </p><input class="form-control" type="number" ng-model="matrix.numRows" /></div>
	<div><p class="inline">Numero di colonne: </p><input class="form-control" type="number" ng-model="matrix.numCols" /></div>
</form>
<h4 ng-bind="matrix.m.display()"></h4>
	
</div>