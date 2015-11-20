<div class="container">
    <div class="modal-wrapper">
        <div class="container">
            <h2>Seleziona il  tuo nuovo avatar</h2>
            <form id="avatarForm" name="avatarForm" ng-submit="avatar.submit()" novalidate>
				<span class="fa-stack fa-5x" ng-if="avatar.temp">
	            	<img class="navbar-avatar" ng-src="avatar.temp">
	            </span>
            	<span class="fa-stack fa-5x" ng-if="!avatar.temp">
	            	<i class="fa fa-users fa-stack-2x"></i>
	            	<i class="fa fa-question fa-stack-1x olive"></i>
	            </span>
            	
            	<input form="avatarForm" id="file" name="file" type="file" required></input>
				<input class="modal-submit" type="submit" ng-class="{'btn-success' : avatarForm.$valid, 'btn-grey' : avatarForm.$invalid}" value="Invia" />
            	<input class="modal-cancel" ng-click="avatar.dismiss()" value="Annulla" readonly/>
        	</form>
    	</div>
	</div>
</div>