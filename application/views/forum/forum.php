<div id="forum">
	<h1>Forum di reSeed</h1>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-body">
				<input type="text" class="form-control bold" placeholder="Inserisci qui l'oggetto del tuo messaggio">
				<div 	text-angular ng-model="forum.forumNewMessage"
						ta-toolbar="[['bold','italics','underline', 'strikeThrough'],['ul', 'ol'],['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],['indent', 'outdent'],['undo', 'redo', 'clear'],['insertImage', 'insertLink', 'insertVideo']]">
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