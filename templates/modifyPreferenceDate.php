<div class="container">
	<div class="modal-wrapper">
		<div class="container">
			<form id="modifyPreferenceForm" name="modifyPreferenceForm" ng-submit="preference.close(preference.form[preference.data.id])" novalidate>
				<p><span ng-bind="preference.data.title"></span> attuale: <span ng-bind="preference.data.value"></span></p>
				<uib-datepicker datepicker-mode="'year'" init-date="initDate" ng-model="preference.form[preference.data.id]" class="well well-sm"></uib-datepicker>
				<input class="modal-submit btn-success" type="submit" value="Modifica" />
                <input class="modal-cancel" ng-click="$dismiss()" value="Annulla" readonly />		
			</form>
		</div>
	</div>
</div>