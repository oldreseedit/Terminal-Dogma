<div id="tutorials">
	<div class="container">
		<h1 class="text-center">Tutorial di reSeed</h1>

		<div ng-if="admin" class="buttons text-center" style="position:fixed; bottom:2em; right: 1em;">
			<a class="btn btn-info" href="write-tutorial"><i class="fa fa-file-text"></i> Scrivi un tutorial</a>
		</div>
		
		<div spinner="tutorialC.tutorialAjax">
			<spinner-place></spinner-place>
			<spinner-final>
				
				<div style="text-align:center; margin-bottom:30px;">
				<h2 style="display: inline-block; vertical-align: sub;" title="Mentre digiti verranno scartati i tutorial che non rispondono alla ricerca da te effettuata.">Cerca tra tutti i tutorial:</h2>
				<input style="display: inline-block; width: 60%; margin-left: 10px;" placeholder="Digita delle parole chiave. Esempi: Java, modello, background-color, ereditarietà classi..." type="text" ng-model="tutorialC.query"/>
				</div>
				
				<div class="tutorial" ng-repeat="tutorial in tutorialC.tutorials | searchFor:tutorialC.query">
					<div class="row">
						<div class="col-lg-2 text-center" equal-height>
							<a style="display: inline-block; position: relative; top: 50%; transform: translateY(-50%);" ng-href="/tutorial/{{tutorial.tutorialID}}">
								<img ng-if="!tutorial.mainImage" class="tutorial-icon resp-img" ng-src="imgs/no-image.png">
								<img ng-if="tutorial.mainImage" class="resp-img" ng-src="{{tutorial.mainImage}}">
							</a>
						</div>
						<div class="col-lg-10" equal-height>
							<div class="tutorial-title">
								<a ng-href="/tutorial/{{tutorial.tutorialID}}"><span ng-bind-html="tutorial.title"></span></a>
								<a ng-if="admin" title="Modifica il tutorial" style="float:right; margin-right:10px;" ng-href="/write-tutorial/{{tutorial.tutorialID}}"><span class="fa fa-pencil"></span></a>
							</div>
							<div class="tutorial-preview">
								<div class="tutorial-course">
									<div><strong>Corso di:</strong> <span ng-bind-html="tutorial.course"></span></div>
<!-- 									<div><strong>Pubblicato:</strong> <span class="tutorial-time" title="Esattamente il {{tutorial.exactTime}}" ng-bind="tutorial.time"></span></div> -->
								</div>
								<div class="tutorial-description">
									<compile-html src="tutorial.description"></compile-html>
								</div>
								<div class="tutorial-footer">
									<div class="tutorial-readmore"><a ng-href="/tutorial/{{tutorial.tutorialID}}">Leggi il tutorial...</a></div>
	<!-- 								<div> -->
	<!-- 									<div class="tutorial-course">Tags:</div> -->
	<!-- 									<span class="tutorial-tag" ng-bind-html="tag" ng-repeat="tag in tutorial.tags"></span> -->
	<!-- 								</div> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</spinner-final>
		</div>		
	</div>
</div>