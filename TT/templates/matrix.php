<div id="TT-matrix" ng-controller="matrixCtrl as matrix">

<!-- <form class="form-inline"> -->
<!-- 	<div><p class="inline">Numero di righe: </p><input class="form-control" type="number" ng-model="matrix.numRows" min="1" /></div> -->
<!-- 	<div><p class="inline">Numero di colonne: </p><input class="form-control" type="number" ng-model="matrix.numCols" min="1"/></div> -->
<!-- </form> -->
<h4 >
	<span ng-bind="'\\( ' + matrix.A.display() + '\\)'" math math-object="matrix.A"></span>
	<span math>\( + \)</span>
	<span ng-bind="'\\( ' + matrix.B.display() + '\\)'" math math-object="matrix.B"></span>
	<span math>\( = \)</span>
	<span ng-bind="'\\( ' + matrix.A.plus(matrix.B).display() + '\\)'" math></span>
</h4>
<!--  + matrix.B.display('part') + '=' + matrix.C.display('part') + '\\]'" ></h4> -->
<!-- <h4 math ng-bind="'\\[ ' + matrix.A.display('part') + matrix.B.display('part') + '=' + matrix.D.display('part') + '\\]'" ></h4> -->

<!-- <h4>Determinante: <span math ng-bind="'\\(' + matrix.determinant + '\\)'"></span></h4> -->

</div>