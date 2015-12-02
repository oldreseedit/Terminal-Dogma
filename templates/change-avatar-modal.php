<div class="container">
    <div class="modal-wrapper">
        <div class="container">
            <h2>Seleziona il  tuo nuovo avatar</h2>
            <form id="avatarForm" name="avatarForm" ng-submit="avatarModal.submit()" novalidate>
				<span class="fa-stack fa-5x" ng-if="avatarModal.temp">
	            	<img class="avatar" ng-src="{{avatarModal.temp}}">
	            </span>
            	<span class="fa-stack fa-5x" ng-if="!avatarModal.temp">
	            	<i class="fa fa-question-circle fa-stack-2x"></i>
	            </span>
            	
            	<input form="avatarForm" type="file"  file-change="avatarModal.uploadTempAvatar(file)"></input>
            	<input form="avatarForm" type="text" ng-model="avatarModal.avatarURI"></input>
				<input class="modal-submit" type="submit" ng-class="{'btn-success' : avatarForm.$valid, 'btn-grey' : avatarForm.$invalid}" value="Invia" />
            	<input class="modal-cancel" ng-click="avatarModal.dismiss()" value="Annulla" readonly/>
        	</form>
    	</div>
	</div>
</div>