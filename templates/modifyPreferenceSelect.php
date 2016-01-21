<div class="container">
	<div class="modal-wrapper">
		<div class="container">
			<form id="modifyPreferenceForm" name="modifyPreferenceForm" ng-submit="preference.close(preference.form.value)" novalidate>
				<p><span ng-bind="preference.data.title"></span> attuale: <span ng-bind="preference.data.value"></span></p>
				<select class="form-control" ng-model="preference.form.value" ng-options="choice as choice for choice in preference.data.choices" required="required">
					<option></option>
				</select>
				<input class="modal-submit btn-success" type="submit" value="Modifica" />
                <input class="modal-cancel" ng-click="$dismiss()" value="Annulla" readonly />		
			</form>
		</div>
	</div>
</div>