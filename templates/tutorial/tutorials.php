<div id="tutorials">
	<div class="container">
		<h1 class="text-center">Tutorial di reSeed</h1>
		
		<div spinner="tutorialC.tutorialAjax">
			<spinner-place></spinner-place>
			<spinner-final>
				
				<h2 title="Mentre digiti verranno scartati i tutorial che non rispondono alla ricerca da te effettuata.">Cerca tra tutti i tutorial:</h2>
				<input style="margin-bottom:100px;" placeholder="Digita delle parole chiave. Esempi: Java, modello, background-color, ereditarietà classi..." type="text" ng-model="tutorialC.query"/>
				
				<div class="tutorial" ng-repeat="tutorial in tutorialC.tutorials | searchFor:tutorialC.query">
					<div class="row">
						<div class="col-lg-4 text-center" equal-height>
							<a ng-href="/tutorial/{{tutorial.url}}">
								<img ng-if="!tutorial.images" class="tutorial-icon" height="128px" ng-src="imgs/no-image.png">
								<img ng-if="tutorial.images" class="resp-img" ng-src="{{tutorial.images}}">
							</a>
						</div>
						<div class="col-lg-8" equal-height>
							<div class="tutorial-title">
								<a ng-href="/tutorial/{{tutorial.url}}"><span ng-bind-html="tutorial.title"></span></a>
								<a ng-if="admin" title="Modifica il tutorial" style="float:right; margin-right:10px;" ng-href="/write-tutorial/{{tutorial.url}}"><span class="fa fa-pencil"></span></a>
							</div>
							<div class="tutorial-course">
								<div><strong>Corso di:</strong> <span ng-bind-html="tutorial.course"></span></div>
								<div><strong>Pubblicato:</strong> <span class="tutorial-time" title="Esattamente il {{tutorial.exactTime}}" ng-bind="tutorial.time"></span></div>
							</div>
							<div class="tutorial-description" ng-bind-html="tutorial.description"></div>
							<div class="tutorial-footer">
								<div class="tutorial-readmore"><a ng-href="/tutorial/{{tutorial.url}}">Leggi il tutorial...</a></div>
<!-- 								<div> -->
<!-- 									<div class="tutorial-course">Tags:</div> -->
<!-- 									<span class="tutorial-tag" ng-bind-html="tag" ng-repeat="tag in tutorial.tags"></span> -->
<!-- 								</div> -->
							</div>
						</div>
					</div>
				</div>
			</spinner-final>
		</div>		
	</div>
</div>