<div class="container">
	<div class="modal-wrapper">
		<div class="container">
			<form class="form-inline" id="modifyPreferenceForm" name="modifyPreferenceForm" ng-submit="preference.close(preference.form.value)" novalidate>
				<p><span ng-bind="preference.data.title"></span> attuale: <span ng-bind="preference.data.value"></span></p>
				<div class="form-group">
					<select ng-init="preference.form.addressPrefix = preference.addressPrefixChoices[0]" class="form-control" ng-model="preference.form.addressPrefix" ng-options="choice as choice for choice in preference.addressPrefixChoices" required="required">
					</select>
				</div>
				<bootstrap-input id="address" form="modifyPreferenceForm" name="address" class="{{preference.data.id}}" placeholder="Indirizzo"  type="text" ng-model="preference.form.address" required="required"></bootstrap-input>
				<bootstrap-input form="modifyPreferenceForm" name="civicNumber" class="{{preference.data.id}}" placeholder="N°"  type="number" ng-model="preference.form.civicNumber" required="required"></bootstrap-input>
				<bootstrap-input form="modifyPreferenceForm" name="CAP" class="{{preference.data.id}}" placeholder="CAP"  type="number" ng-model="preference.form.CAP" required="required"></bootstrap-input>
				<input class="modal-submit btn-success" type="submit" value="Modifica" />
                <input class="modal-cancel" ng-click="$dismiss()" value="Annulla" readonly />		
			</form>
		</div>
	</div>
</div>