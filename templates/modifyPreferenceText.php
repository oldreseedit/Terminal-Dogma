<div class="container">
	<div class="modal-wrapper">
		<div class="container">
			<form id="modifyPreferenceForm" name="modifyPreferenceForm" ng-submit="preference.close(preference.form.value)" novalidate>
				<p><span ng-bind="preference.data.title"></span> attuale: <span ng-bind="preference.data.value"></span></p>
				<bootstrap-input form="modifyPreferenceForm" name="{{preference.data.id}}" type="text" ng-model="preference.form.value" placeholder="{{preference.placeholder()}}" required="required"></bootstrap-input>
				<input class="modal-submit btn-success" type="submit" value="Modifica" />
                <input class="modal-cancel" ng-click="$dismiss()" value="Annulla" readonly />
			</form>
		</div>
	</div>
</div>