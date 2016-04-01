<div id="tutorial">

	<div class="container">	
		<div spinner="tutorialV.tutorialInfoAjax">
			<spinner-place class="fa-4x"></spinner-place>
			<spinner-final>
					<div class="course-button clickable" ng-if="!imOnResponsive && tutorialV.tutorial.course">
						<a ng-href="/courses/{{tutorialV.tutorial.courseID}}">
							<img src="imgs/tutorial-seecourse.png">
						</a>
					</div>
					<div  ng-repeat="item in tutorialV.items" ng-init="index = $index">
						<div class="clearfix" ng-if="tutorialV.isNewRow(index)"></div>
						<div class="no-gridster-item bg-light-grey" ng-class="tutorialV.getItemClass(item)" ng-style="item.noMaxHeight ? {'max-height':  'none'} : ''">
							<div class="container text-left">
								<div class="panel-title bg-leaf">
									<h4 ng-bind="item.title"></h4>
								</div>
<!-- 								<div class="scrollbar-wrapper"> -->
<!-- 									<div class="scrollbar"> -->
										<div class="panel-content">
											<div class="container">
												<div ng-include="item.templateUrl"></div>
											</div>
										</div>
<!-- 									</div> -->
<!-- 								</div> -->
							</div>
						</div>
					</div>
					
					<div ng-repeat="step in tutorialV.tutorial.body">
						<div class="clearfix"></div>

						<div class="no-gridster-item bg-light-grey" ng-class="col-100">
						    <div class="container">
						        
						        <div class="panel-title bg-leaf"><h4 ng-bind="step.title"></h4></div>
						        
				                <div class="panel-content">
				                    <div class="container">
				                        <div style="text-align:left;">
											<compile-html src="step.content"></compile-html>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="buttons text-center" style="text-align:left; position:fixed; bottom:1em; left: 1em;">
						<div style="padding-bottom: 0.5em;"><a ng-if="admin" class="btn btn-success" href="write-tutorial/{{tutorialV.tutorial.tutorialID}}">Modifica questo tutorial</a></div>
						<div><a class="btn btn-info" href="tutorials">Torna ai tutorial</a></div>
					</div>
			</spinner-final>
		</div>
	</div>
</div>