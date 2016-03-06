<div id="preferences" spinner="preferences.getAjax">
	<spinner-place class="fa-5x"></spinner-place>
	<spinner-final>
		<h2>Pannello utente</h2>
		<div class="btn-group" role="group">
			<button type="button" class="btn btn-default" ng-click="preferences.set()" spinner="preferences.setAjax">
				<spinner-place class="fa-2x"></spinner-place>
				<spinner-final>
					<i class="fa fa-2x fa-floppy-o"></i><span class="sep"></span><span>Salva preferenze</span>
				</spinner-final>
			</button>
		</div>
		<h3>Informazioni utente</h3>
		<table class="table table-striped table-condensed text-left">
			<tr ng-repeat="row in preferences.data">
				<td><p class="bold" ng-bind="row.title" ></p></td>
				<td><p class="bold" ng-bind="row.value" ></p></td>
				<td><div class="separator"></div></td>
				<td><p><span class="modify" ng-if="preferences.isModifiable(row.id)" ng-click="preferences.modify(row)"><i class="fa fa-pencil"></i> <small>Modifica</small></span></p></td>
			</tr>
		</table>
		<h3>Preferenze utente</h3>
		<div class="panel panel-default">
			<div class="panel-body text-left">
				<div class="checkbox" ng-repeat="right in preferences.rights">
				   	<input type="checkbox" ng-model="right.value" ng-true-value="1" ng-false-value="0">
				    <label><p class="inline no-padding"><span ng-bind="right.description"></span></p></label>
				</div>
			</div>
		</div>
	</spinner-final>
</div>