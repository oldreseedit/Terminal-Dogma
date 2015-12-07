<div class="container">
    <div class="modal-wrapper">
        <div class="container">
            <h2>Seleziona il  tuo nuovo avatar</h2>
            <form id="avatarForm" name="avatarForm" ng-submit="avatarModal.submit()" novalidate>
				<span class="fa-stack fa-5x" ng-if="avatarModal.temp">
	            	<img ng-src="{{avatarModal.temp}}" ng-class="{'avatar': !avatarModal.isDefaultAvatar(), 'avatar-leaf' : avatarModal.isDefaultAvatar()}">
	            </span>
            	<span class="fa-stack fa-5x" ng-if="!avatarModal.temp">
	            	<i class="fa fa-question-circle fa-stack-2x"></i>
	            </span>
            	
            	<div class="container">
	            	<label for="file">Carica un file</label>
	            	<input id="file" form="avatarForm" type="file"  file-change="avatarModal.uploadTempAvatar(file)"></input>
	            	<uib-progressbar ng-if="loading" value="current" max="total" type="success" ><span ng-bind="avatarModal.getPercent()"></span></uib-progressbar>
	            	<label for="uri">o incolla un URI</label>
	            	<input id="uri" form="avatarForm" type="text" ng-model="avatarModal.avatarURI"></input>
					<input class="modal-submit" type="submit" ng-class="{'btn-success' : avatarForm.$valid, 'btn-grey' : avatarForm.$invalid}" value="Salva" />
	            	<input class="modal-cancel" ng-click="$dismiss()" value="Annulla" readonly/>
	            </div>
        	</form>
    	</div>
	</div>
</div>