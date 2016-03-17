<div id="TT-matrix" ng-controller="matrixCtrl as matrix">

<form class="form-inline">
	<div><p class="inline">Numero di righe: </p><input class="form-control" type="number" ng-model="matrix.numRows" min="1" /></div>
	<div><p class="inline">Numero di colonne: </p><input class="form-control" type="number" ng-model="matrix.numCols" min="1"/></div>
</form>
<h4 ng-bind="matrix.m.display('standalone')" math></h4>

<h4>Determinante: \({{matrix.m.determinant()}}\)</h4>

</div>