<div id="news-events" ng-controller="newsController as news" spinner="news.getAjax">
	<spinner-place class="fa-5x"></spinner-place>
	<spinner-final>
		<div ng-repeat="row in news.newsByRow" class="black">
			<div class="news" ng-repeat="event in row" ng-init="index=$index"  ng-class="presentation.spacedTabs($first)">
				<div  ng-class="presentation.getColour(index)">
					<div class="container">
						<div class="news-icon" centered><i class="fa white" ng-class="news.getIconClass(event)" fittext fittext-exclusive="width"></i></div>
						<div class="news-title text-left" centered>
							<h5><b ng-bind-html="event.title"></b></h5>
							<p ng-if="event.type==='event'" class="darker-grey">
								<small>
									<b>Quando: </b><span ng-bind="news.getDate(event)"></span>
								</small>
							</p>
							<p ng-if="event.type==='event'" class="darker-grey">
								<small>
									<b>Dove: </b><span ng-bind="event.place"></span>
								</small>
							</p>
						</div>
					</div>
				</div>
				<div class="news-description" ng-class="presentation.getDarkColour(index)">
					<span ng-bind="event.description"></span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</spinner-final>
</div>