<div id="profile">
	<div class="container">
		<div spinner="profile.userInfo">
			<spinner-place class="fa-4x"></spinner-place>
			<spinner-final>
				<div ng-if="profile.isMyProfile() || profile.visible">
					<div  ng-repeat="item in profile.items" ng-init="index = $index">
						<div class="clearfix" ng-if="profile.isNewRow(index)"></div>
						<div class="no-gridster-item bg-light-grey" ng-class="profile.getItemClass(item)" ng-style="item.noMaxHeight ? {'max-height':  'none'} : ''">
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
				</div>
				<div ng-if="!profile.visible">
					<h3><i class="text-danger fa fa-2x fa-exclamation-triangle"></i></h3><h3> Questo profilo è privato</h3>
					<p>Non ci si fa gli affari altrui!</p>
				</div>
			</spinner-final>
		</div>
	</div>
</div>