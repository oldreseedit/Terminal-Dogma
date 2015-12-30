<div id="forum">
	<h1>Forum di reSeed</h1>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><h2>Discussioni aperte</h2></div>
			<div class="panel-body">
				<div>
					<table class="table table-striped">
					    <tr>
					    	<th></th>
					    	<th class="forum-description"><p>Descrizione</p></th>
						    <th><p>Thread</p></th>
						    <th><p>Visite</p></th>
						    <th><p>Risposte</p></th>
						    <th><p>Partecipanti</p></th>
					    </tr>
					    <tr ng-repeat="discussion in forum.discussions">
					        <td><a href="forum/discussion/{{discussion.id}}"><i class="fa {{discussion.icon}}"></i></a></td>
					        <td>
					        	<div class="forum-description">
						        	<p><a href="forum/discussion/{{discussion.id}}" ng-bind="discussion.title"></a></p>
						        	<p ng-bind="discussion.description"></p>
						        </div>
					        </td>
					        <td ng-bind="discussion.threads"></td>
					        <td ng-bind="discussion.views"></td>
					        <td ng-bind="discussion.replies"></td>
					        <td ng-bind="discussion.participants"></td>
					    </tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<button type="button" ng-click="forum.showMessageBoard = true" class="btn btn-success background-image-none bg-water">Rispondi</button>

	<div class="container forum-message" ng-show="forum.showMessageBoard">
		<div class="panel panel-default">
			<div class="panel-body">
				<input type="text" class="form-control bold" placeholder="Inserisci qui l'oggetto del tuo messaggio">
				<div text-angular ng-model="forum.forumNewMessage"
						ta-toolbar="[['bold','italics','underline', 'strikeThrough'],['ul', 'ol'],['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],['indent', 'outdent', 'quote'],['undo', 'redo', 'clear'],['insertImage', 'insertLink', 'insertVideo']]">
				</div>
			</div>
			
			<div class="panel-footer clearfix">
				<div class="col-xs-6">	
					<div class="btn-group pull-left" role="group">
					  <button type="button" class="btn btn-default fa fa-paper-plane"></button>
					</div>
				</div>
				<div class="col-xs-6">	
					<div class="btn-group pull-right" role="group">
					  <button type="button" class="btn btn-default fa fa-trash"></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>