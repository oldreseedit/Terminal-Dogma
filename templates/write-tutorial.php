<div id="write-tutorial">
	<div class="container">
		<h1>Titolo del tutorial</h1>
		<p>Fornisci un titolo. Sii conciso.</p>
		<input placeholder="Titolo" type="text" ng-model="writeTutorial.tutorialTitle"/>
		
		<h1>Titolo del tutorial</h1>
		<p>Scegli il corso per cui stai scrivendo questo tutorial (o in ogni caso quello che ritieni essere più vicino).</p>
		<select name="subject" style="font-size: 1.3em; padding: 20px; font-weight: bold;"
			ng-options="course.name for course in writeTutorial.courses"
			ng-model="writeTutorial.tutorialCourse">
			<option value="" disabled>Scegli il corso</option>
		</select>
		
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
			<button class="btn btn-success" ng-disabled="writeTutorial.tutorialTitle == '' || writeTutorial.tutorialBody == ''" ng-click="writeTutorial.send()">{{writeTutorial.tutorialID == '' ? 'Salva tutorial' : 'Aggiorna tutorial'}}</button>
		</div>
	</div>
</div>