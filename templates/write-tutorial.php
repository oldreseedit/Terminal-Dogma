<div id="write-tutorial">
	<div class="container">
		<h1>Titolo del tutorial</h1>
		<p>Fornisci un titolo. Max 100 caratteri.</p>
		<input placeholder="Titolo" type="text" ng-model="writeTutorial.tutorialTitle"/>
		<p><strong>Anteprima url:</strong> www.reseed.it/tutorial/<span ng-bind="writeTutorial.tutorialID"></span></p>		
		
		<h1>Corso del tutorial</h1>
		<p>Scegli il corso per cui stai scrivendo questo tutorial (o in ogni caso quello che ritieni essere più vicino).</p>
		<select name="subject" style="font-size: 1.3em; padding: 20px; font-weight: bold;"
			ng-options="course.name for course in writeTutorial.courses"
			ng-model="writeTutorial.tutorialCourse">
			<option value="" disabled>Scegli il corso</option>
		</select>
		
		<h1>Scegli le immagini:</h1>
		<input type="file" nv-file-select uploader="writeTutorial.uploader"/><br/>
<!--         <ul> -->
<!--             <li ng-repeat="item in writeTutorial.uploader.queue"> -->
<!--                 Name: <span ng-bind="item.file.name"></span><br/> -->
<!--                 <button ng-click="item.upload()">upload</button> -->
<!--             </li> -->
<!--         </ul> -->
        
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
		
		<h1>Breve descrizione</h1>
		<p>Fornisci una breve descrizione, di 2-3 righe del tutorial.</p>
		<div placeholder="Descrizione" text-angular ng-model="writeTutorial.tutorialShortDescription"></div>
		
		<h1>Requisiti (hardware/software)</h1>
		<p>Qui dovresti inserire tutti gli strumenti necessari a (e)seguire il tutorial</p>
		<div placeholder="Requisiti" text-angular ng-model="writeTutorial.tutorialRequirements"></div>
		
		<h1>Corpo del tutorial</h1>
		<p>Corpo del tutorial: qui ci dovrebbero essere le vere e proprie istruzioni.</p>
		<div placeholder="Corpo del tutorial" text-angular ng-model="writeTutorial.tutorialBody"></div>
		
		<h1>Tags</h1>
		<p>Inserisci qui i tag separati da spazi. Per parole composte usa gli underscore.</p>
		<input placeholder="Tags" type="text" ng-model="writeTutorial.tutorialTags"/>
		
		<h1>See also</h1>
		<p>Inserisci qui dei link a pagine (interne o esterne) che vuoi consigliare al lettore. Potrebbe essere una buona idea puntare ad altre pagine del sito, a pagine "autorevoli" (e.g., Wikipedia) o per inserire una specie di bibliografia.</p>
		<div placeholder="See also" text-angular ng-model="writeTutorial.tutorialSeealso"></div>
		
		<div class="buttons text-center">
			<button class="btn btn-success" ng-disabled="writeTutorial.tutorialTitle == '' || writeTutorial.tutorialBody == ''" ng-click="writeTutorial.send()">{{writeTutorial.mode == 'write' ? 'Salva tutorial' : 'Aggiorna tutorial'}}</button>
		</div>
	</div>
</div>