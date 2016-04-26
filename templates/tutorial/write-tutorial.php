<div id="write-tutorial" tabindex="0" ng-keydown="writeTutorial.ctrlS($event)">
	<div class="container">
		<h1>Titolo del tutorial</h1>
		<p>Fornisci un titolo. Max 100 caratteri.</p>
		<input placeholder="Titolo" type="text" ng-model="writeTutorial.tutorialTitle"/>
		<p><strong>Anteprima url:</strong> www.reseed.it/tutorial/<span ng-bind="writeTutorial.tutorialID"></span></p>		
		
		<h1>Corso del tutorial</h1>
		<p>Scegli il corso per cui stai scrivendo questo tutorial (o in ogni caso quello che ritieni essere più vicino).</p>
		<select name="subject" style="font-size: 1.3em; padding: 20px; font-weight: bold;"
			ng-options="course.name for course in writeTutorial.courses track by course.name"
			ng-model="writeTutorial.tutorialCourse">
			<option value="" disabled>Scegli il corso</option>
		</select>
		
		<h1>Scegli le immagini:</h1>
		<input type="file" nv-file-select uploader="writeTutorial.uploader"/><br/>
        			<table class="table">
                        <thead>
                            <tr>
                                <th width="50%">Name</th>
                                <th ng-show="writeTutorial.uploader.isHTML5">Size</th>
                                <th ng-show="writeTutorial.uploader.isHTML5">Progress</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in writeTutorial.uploader.queue">
                                <td><strong>{{ item.file.name }}</strong></td>
                                <td ng-show="writeTutorial.uploader.isHTML5" nowrap>{{ (item.file.size > 1024*1024 ? item.file.size/1024/1024 : item.file.size/1024) | number:2 }} {{item.file.size > 1024*1024 ? 'MB' : 'KB'}}</td>
                                <td ng-show="writeTutorial.uploader.isHTML5">
                                    <div class="progress" style="margin-bottom: 0;">
                                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span ng-show="item.isSuccess"><i class="fa fa-icon fa-check"></i></span>
                                    <span ng-show="item.isCancel"><i class="fa fa-icon fa-ban"></i></span>
                                    <span ng-show="item.isError"><i class="fa fa-icon fa-times"></i></span>
                                </td>
                                <td nowrap>
                                    <button type="button" class="btn btn-success btn-xs" ng-click="item.upload()" ng-disabled="item.isReady || item.isUploading || item.isSuccess">
                                        <span class="fa fa-icon fa-upload"></span> Upload
                                    </button>
                                    <button type="button" class="btn btn-warning btn-xs" ng-click="item.cancel()" ng-disabled="!item.isUploading">
                                        <span class="fa fa-icon fa-ban"></span> Cancel
                                    </button>
                                    <button type="button" class="btn btn-danger btn-xs" ng-click="item.remove()">
                                        <span class="fa fa-icon fa-trash"></span> Remove
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div>
                        <div>
                            Queue progress:
                            <div class="progress" style="">
                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': writeTutorial.uploader.progress + '%' }"></div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-s" ng-click="writeTutorial.uploader.uploadAll()" ng-disabled="!writeTutorial.uploader.getNotUploadedItems().length">
                            <span class="fa fa-icon fa-upload"></span> Upload all
                        </button>
                        <button type="button" class="btn btn-warning btn-s" ng-click="writeTutorial.uploader.cancelAll()" ng-disabled="!writeTutorial.uploader.isUploading">
                            <span class="fa fa-icon fa-ban"></span> Cancel all
                        </button>
                        <button type="button" class="btn btn-danger btn-s" ng-click="writeTutorial.uploader.clearQueue()" ng-disabled="!writeTutorial.uploader.queue.length">
                            <span class="fa fa-icon fa-trash"></span> Remove all
                        </button>
                    </div>
                    
		<div ng-repeat="image in writeTutorial.tutorialImages track by $index" ng-init="$index"">
			<img style="max-width: 50%;" ng-src="{{image}}">
	        <a class="btn btn-danger" ng-click="writeTutorial.removeImage($index)">Rimuovi</a>
    	    <a class="btn btn-info" clipboard on-copied="writeTutorial.copyLinkOK(image)" on-error="writeTutorial.copyLinkFailed(image)" text="image"><i class="fa fa-link"></i> Get link</a>
		</div>
		
		<h1>Breve descrizione</h1>
		<p>Fornisci una breve descrizione, di 2-3 righe del tutorial.</p>
		<div placeholder="Descrizione" text-angular ng-model="writeTutorial.tutorialShortDescription"></div>
		
		<h1>Requisiti (hardware/software)</h1>
		<p>Qui dovresti inserire tutti gli strumenti necessari a (e)seguire il tutorial</p>
		<div placeholder="Requisiti" text-angular ng-model="writeTutorial.tutorialRequirements"></div>
		
		<h1>Corpo del tutorial</h1>
		<p>Corpo del tutorial: qui ci dovrebbero essere le vere e proprie istruzioni.</p>
		
		<div ng-repeat="step in writeTutorial.tutorialBody" ng-init="$index">
			<input type="text" ng-model="step.title"></input>
			<div style="padding:1em;">
				<a ng-if="step.hidden" ng-click="step.hidden=false" class="btn btn-info"><i class="fa fa-eye"></i> Mostra</a>
				<a ng-if="!step.hidden" ng-click="step.hidden=true" class="btn btn-info"><i class="fa fa-eye-slash"></i> Nascondi</a>
			</div>
			<div ng-if="!step.hidden" placeholder="Corpo del tutorial" text-angular ng-model="step.content"></div>
			<div style="padding:1em;">
				<a ng-if="writeTutorial.tutorialBody.length > 1" class="btn btn-danger" ng-click="writeTutorial.removeStep($index)"><i class="fa fa-minus"></i> Rimuovi passo</a>
				<a class="btn btn-success" ng-click="writeTutorial.addStep($index+1)"><i class="fa fa-plus"></i> Aggiungi passo</a>
			</div>
			<hr/>
		</div>
		
		<h1>Tags</h1>
		<p>Inserisci qui i tag separati da spazi. Per parole composte usa gli underscore.</p>
		<input placeholder="Tags" type="text" ng-model="writeTutorial.tutorialTags"/>
		
		<h1>Immagine principale</h1>
		<p>Vuoi che ci sia un'immagine principale nel tutorial? Incolla l'URL qui.</p>
		<input placeholder="Immagine principale" type="text" ng-model="writeTutorial.tutorialMainImage"/>
		
		<h1>See also</h1>
		<p>Inserisci qui dei link a pagine (interne o esterne) che vuoi consigliare al lettore. Potrebbe essere una buona idea puntare ad altre pagine del sito, a pagine "autorevoli" (e.g., Wikipedia) o per inserire una specie di bibliografia.</p>
		<div placeholder="See also" text-angular ng-model="writeTutorial.tutorialSeealso"></div>
		
		<div class="buttons text-center" style="position:fixed; bottom:-2em; left: 1em;">
			<a class="btn btn-info" href="tutorials"><i class="fa fa-chevron-circle-left"></i> Torna ai tutorial</a>
		</div>
		<div class="buttons text-center" style="position:fixed; bottom:-2em; right: 1em;">
			<a class="btn btn-success" ng-disabled="writeTutorial.tutorialTitle == '' || writeTutorial.tutorialBody == ''" ng-click="writeTutorial.send()">{{writeTutorial.mode == 'write' ? 'Salva tutorial' : 'Salva le modifiche'}}</a>
			<a ng-href="{{'/tutorial/'+writeTutorial.tutorialID}}" target="_blank" class="btn btn-success" ng-disabled="writeTutorial.tutorialTitle == '' || writeTutorial.tutorialBody == ''" ng-click="writeTutorial.preview()">Vedi anteprima</a>
		</div>
	</div>
</div>

<!-- Per limitare/personalizzare la toolbar, includere il seguente attributo: ta-toolbar="[['h1','h2','h3','html'],['bold','italics','colourRed']]" -->