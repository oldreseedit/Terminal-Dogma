<div id="tutorials">
	<div class="container">
		<h1 class="text-center">Tutorial di reSeed</h1>
		
		<div spinner="tutorialC.tutorialAjax">
			<spinner-place></spinner-place>
			<spinner-final>
				
				<h2>Cerca tra tutti i tutorial:</h2>
				<input style="margin-bottom:100px;" placeholder="Digita delle parole chiave" type="text" ng-model="tutorialC.query"/>
				
				<div class="tutorial" ng-repeat="tutorial in tutorialC.tutorials | searchFor:tutorialC.query">
					<div class="row">
						<div class="col-lg-2 text-center" equal-height>
							<img class="tutorial-icon" height="128px" ng-src="{{tutorial.icon}}">
						</div>
						<div class="col-lg-10" equal-height>
							<div class="tutorial-title" ng-bind-html="tutorial.title"></div>
							<div class="tutorial-course" ng-bind-html="tutorial.course"></div>
							<div class="tutorial-description" ng-bind-html="tutorial.description"></div>
							<div class="tutorial-footer">
								<span class="tutorial-tag" ng-bind-html="tag" ng-repeat="tag in tutorial.tags"></span>
							</div>
						</div>
					</div>
				</div>
			</spinner-final>
		</div>		
	</div>
</div>