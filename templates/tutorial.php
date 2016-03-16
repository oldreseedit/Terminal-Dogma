<div id="tutorial">
	<div class="container">
		<div spinner="tutorialV.tutorialInfoAjax">
			<spinner-place class="fa-4x"></spinner-place>
			<spinner-final>
					<div  ng-repeat="item in tutorialV.items" ng-init="index = $index">
						<div class="clearfix" ng-if="tutorialV.isNewRow(index)"></div>
						<div class="no-gridster-item bg-light-grey" ng-class="tutorialV.getItemClass(item)" ng-style="item.noMaxHeight ? {'max-height':  'none'} : ''">
							<div class="container">
								<div class="panel-title bg-leaf">
									<h4 ng-bind="item.title"></h4>
								</div>
								<div class="scrollbar-wrapper">
									<div class="scrollbar">
										<div class="panel-content">
											<div class="container">
												<div ng-include="item.templateUrl"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<a class="btn btn-success" href="write-tutorial/{{tutorialV.tutorial.tutorialID}}">Modifica</a>
			</spinner-final>
		</div>
	</div>
</div>