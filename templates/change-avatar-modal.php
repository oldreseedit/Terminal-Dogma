<div class="container">
    <div class="modal-wrapper">
        <div class="container">
            <h2>Seleziona il  tuo nuovo avatar</h2>
            <form id="avatarForm" name="avatarForm" ng-submit="avatarModal.submit()" novalidate>
	            <div  spinner="avatarModal.tempUriAjax">
					<span class="fa-stack fa-5x" ng-show="avatarModal.temp">
						<spinner-place ng-show="avatarModal.loading"></spinner-place>					
		            	<img ng-src="{{avatarModal.temp}}" ng-class="{'avatar': !avatarModal.isDefaultAvatar(), 'avatar-leaf' : avatarModal.isDefaultAvatar()}" spinner-final ng-show="!avatarModal.loading">
		            </span>
	            	<span class="fa-stack fa-5x" ng-show="!avatarModal.temp">
						<spinner-place ng-show="avatarModal.loading"></spinner-place>
		            	<i class="fa fa-question-circle fa-stack-2x" ng-show="!avatarModal.loading"></i>
		            </span>
	            </div>
            	
            	<div class="container">
	            	<label for="file"><p>Carica un file</p></label>
	            	<input id="file" form="avatarForm" type="file"  file-change="avatarModal.uploadTempAvatar(file)"></input>
	            	<uib-progressbar ng-if="loading" class="progress-striped active" value="current" max="total" type="success" ><span ng-bind="avatarModal.getPercent()"></span></uib-progressbar>
	            	<label for="uri"><p>o incolla un URI</p></label>
	            	<input id="uri" form="avatarForm" type="text" ng-model="avatarModal.avatarURI"></input>
					<input class="modal-submit" type="submit" ng-class="{'btn-success' : avatarForm.$valid, 'btn-grey' : avatarForm.$invalid}" value="Salva"></input>
	            	<input class="modal-cancel" ng-click="$dismiss()" value="Annulla" readonly/>
	            </div>
        	</form>
    	</div>
	</div>
</div>